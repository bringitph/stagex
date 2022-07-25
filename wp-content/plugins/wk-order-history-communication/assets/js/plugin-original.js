"use strict";
var wkohc = jQuery.noConflict();
var wkohc_count = 0;

document.addEventListener("DOMContentLoaded", function () {
  if (wkohc('.wkohc-select2').length) {
    wkohc('.wkohc-select2').select2();
  }
});

wkohc(document).ready(function () {

  wkohc('body').on('click', '#wkohc-add-attachment', function(){
    wkohc_count++;
    let html = '';
    html += `<tr id="wkohc-row-${wkohc_count}">`;
    html +=   `<td>`;
    html +=     `<div style="display:flex;">`
    html +=       `<button type="button" class="button wkohc_upload_button" data-file-id="#wkohc_file_${wkohc_count}"><span class="dashicons dashicons-upload"></span></button>`;
    html +=      `<input type="text" class="wkohc_file_name" disabled style="width:174px;"/>`;
    html +=    `</div>`;
    html +=    `<input type="file" name="wkohc_file[]" id="wkohc_file_${wkohc_count}" class="input-text wkohc_file" style="display:none;"/>`;
    html +=  `</td>`;
    html +=  `<td><button type="button" class="button wkohc_remove" data-row-id="#wkohc-row-${wkohc_count}">-</button></td>`;
    html += `</tr>`
    wkohc('#wkohc-tbody').append(html);
  });

  wkohc('body').on('click', '#wkohc-tbody .wkohc_remove', function(){
    let id = wkohc(this).data('row-id');
    wkohc(id).remove();
  });

  wkohc('body').on('click', '#wkohc-tbody .wkohc_upload_button', function(){
    let id = wkohc(this).data('file-id');
    wkohc(id).trigger('click');
  });

  wkohc('body').on('change', '#wkohc-tbody .wkohc_file', function(){
    var name = wkohc(this).val().replace(/C:\\fakepath\\/i, '');
    wkohc(this).parents('td').find('.wkohc_file_name').val(name);
  });

  wkohc('body').on('click', '#wkohc_add_comment', function(){
    let formdata = new FormData();
    wkohc('.wkohc-error').remove();

    let comment = wkohc('#wkohc_comment').val();
    if(wkohc.trim(comment) == '') {
      wkohc('#wkohc_comment').after('<span class="wkohc-error" style="color:red;">' + wkohcObj.text_error_comment + '</span>');
      return false;
    }
    let order_id = wkohc('#wkohc_order_id').val();
    let seller = wkohc('#wkohc_seller').val();

    if(seller == 'seller') {
      formdata.append('action', 'wkohc_save_customer_comment_box');
    } else {
      formdata.append('action', 'wkohc_save_comment_box');
    }

    formdata.append('wkohc_nonce', wkohcObj.ajax.ajaxNonce);
    formdata.append('order_id', order_id);
    formdata.append('comment', comment);

    wkohc('#wkohc-tbody .wkohc_file').each(function(){
      if(wkohc(this).get(0).files[0]) {
        formdata.append('files[]', wkohc(this).get(0).files[0]);
      }
    });

    wkohc_ajax_call(formdata);

  });

  function wkohc_ajax_call(formdata) {

    let seller = wkohc('#wkohc_seller').val();

    if(seller != 'seller') {
      wkohc("html, body").animate({ scrollTop: 0 }, "fast");
    }

    wkohc('body').fadeTo( '400', '0.6' ).block({
      message: wkohcObj.text_processing,
      overlayCSS: {
        opacity: 0.6
      }
    });

    wkohc.ajax({
      type: 'POST',
      url: wkohcObj.ajax.ajaxUrl,
      data: formdata,
      contentType: false,
      processData: false,
      success: function(json){
        wkohc('body').css('opacity', '1');
        window.location.reload();
      }
    });
  }

});
