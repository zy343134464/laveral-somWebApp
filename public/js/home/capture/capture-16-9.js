 $(function() {
  'use strict';
  var console = window.console || { log: function () {} };
  var URL = window.URL || window.webkitURL;
  var $image = $('#image');
  var $download = $('#download');
  var croType = false;
  var options = {
      aspectRatio: 16 / 9,
      preview: '.img-preview',
      dragMode: 'move',
      toggleDragModeOnDblclick: false,
      crop: function (e) {
        croType = true;
      }
    };
  var originalImageURL = $image.attr('src');
  var uploadedImageName = 'cropped.jpg';
  var uploadedImageType = 'image/jpeg';
  var uploadedImageURL;

  // Cropper
  $image.cropper(options);

   
  // Import image
  var $inputImage = $('#inputImage');
  if (URL) {
      $inputImage.change(function () {
        var files = this.files;
        var file;

        if (!$image.data('cropper')) {
          return;
        }

        if (files && files.length) {
          file = files[0];

          if (/^image\/\w+$/.test(file.type)) {
            uploadedImageName = file.name;
            uploadedImageType = file.type;

            if (uploadedImageURL) {
              URL.revokeObjectURL(uploadedImageURL);
            }

            uploadedImageURL = URL.createObjectURL(file);

            $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options).siblings('label').hide();;
            $inputImage.val('');
            $('.manage-btn-box').show();
          } else {
            window.alert('Please choose an image file.');
          }
        }
      });
  } else {
      $inputImage.prop('disabled', true).parent().addClass('disabled');
      $('#posters_picture').attr('src',posters_imgSrc);
  }

  // 放大缩小
  $('.btn-plus').on('click',function() {
    $image.cropper("zoom", 0.1)
  })
  $('.btn-minus').on('click',function() {
    $image.cropper("zoom", -0.1)
  })

  // 确定
  $('.capture-btn.btn-confirm').on('click', function() {
    if(!croType) return;
    var $this = $(this);
    var result = $image.cropper('getCroppedCanvas', {});
    var src = result.toDataURL(uploadedImageType);
    // console.log(uploadedImageURL);
    // console.log($image.cropper("getData"));
    // console.log(src);
    console.log(src);
     var i=1;
    if(src){
       $('#new_game .Modify-div').addClass('active')   
     }

    // 添加图片
    $('.pic').val(src);
    $('.pv').html('<img src="'+ src +'" style="width:100%">');

    // 关闭弹窗
    $this.parents('.pop-info').hide();
    $('.pop-mask').hide();
  })

  // 关闭弹窗
  $('.pop-hide').on('click', function() {
    var $this = $(this);
    $this.parents('.pop-info').hide();
    $('.pop-mask').hide();
  })
})