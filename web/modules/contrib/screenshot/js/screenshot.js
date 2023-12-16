(function ($, Drupal, drupalSettings, once) {
  "use strict";
  Drupal.behaviors.screen_capture = {
    attach: function (context, settings) {
      $(once('screen-capture', '.screen-capture')).on("click", function (e) {
        let config = $(this).data();
        if (config.file_input == 0) {
          $(this).parent().find('input[type="file"]').hide();
        }
        captureScreen(e, config);
      });
    }
  }

  function captureScreen(event, config) {
    event.preventDefault();
    if (!navigator.mediaDevices || !navigator.mediaDevices.getDisplayMedia) {
      alert(Drupal.t('Your browser does not support screen capture. Please use the latest version of Chrome or Firefox.'));
      return;
    }

    navigator.mediaDevices.getDisplayMedia({video: true})
      .then(stream => {
        // Delay the screen capture to give the sharing prompt time to disappear.
        setTimeout(() => {
          handleStream(stream, config);
        }, 500); // Adjust delay as needed.
      })
      .catch(handleError);
  }

  function handleStream(stream, config) {
    const track = stream.getVideoTracks()[0];
    let imageCapture = new ImageCapture(track);
    imageCapture.grabFrame().then((bitmap) => processFrame(bitmap, track, config)).catch(handleError);
  }

  function processFrame(bitmap, track, config) {
    const canvas = document.createElement('canvas');
    drawImageOnCanvas(bitmap, canvas);
    let htmlCode = '';
    if(config.mode == 'modal'){
      const capture = document.createElement('img');
      capture.id = 'captured-image';
      capture.src = canvas.toDataURL();
      $('#'+config.id).html(capture);
      let markerArea = new markerjs2.MarkerArea(capture);
      markerArea.settings.displayMode = 'popup';
      markerArea.addEventListener("render",
        (event) => (capture.src = event.dataUrl)
      );
      markerArea.show();
      markerArea.addEventListener("close", (event) => {
        const base64Image = capture.src;
        capture.remove();
        if (config.url != undefined) {
          config.screenshot = base64Image;
          $.ajax({
            url: config.url,
            type: 'POST',
            cache: false,
            contentType: "application/x-www-form-urlencoded;charset=UTF-8",
            data: config,
            success: function (data) {
              let capture = data[0];
              let inputHidden = $('input[name="' + capture.input_fid + '"]');
              inputHidden.val(capture.fid);
              inputHidden.parent().find('.image-style-thumbnail').hide();
              $('#' + capture.selector + ' img').attr('src', capture.image_src).addClass('image-style-thumbnail');
            }
          });
        } else {
          const filename = "screenshot.png";
          saveImageToFile(base64Image, filename);
          $('#' + config.id).html('');
        }
      });

    } else {
      htmlCode = getHtmlCode(canvas.toDataURL());
      openInNewTab(htmlCode);
    }
    track.stop();
  }

  function saveImageToFile(dataURI, filename) {
    const link = document.createElement('a');
    link.href = dataURI;
    link.download = filename;
    link.style.display = 'none';
    document.body.appendChild(link);
    link.click();
    // Clean up
    document.body.removeChild(link);
  }

  function drawImageOnCanvas(bitmap, canvas) {
    canvas.width = bitmap.width;
    canvas.height = bitmap.height;
    const context = canvas.getContext('2d');
    context.drawImage(bitmap, 0, 0, bitmap.width, bitmap.height);
  }

  function getHtmlCode(image) {
    return `
      <html>
        <head>
          <script src="https://unpkg.com/markerjs2/markerjs2.js"></script>
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />
          <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
        </head>
        <body>
          <img id="captured-image" src="${image}"/>
          <script>
            function showMarkerArea(target) {
              const markerArea = new markerjs2.MarkerArea(target);
              markerArea.addEventListener("render", (event) => {
                target.src = event.dataUrl;
              });
              markerArea.show();
              markerArea.addEventListener("close", (event) => {
                const base64Image = target.src;
                const filename = "screenshot.png";
                saveImageToFile(base64Image, filename);
              });
            }
            function saveImageToFile(dataURI, filename) {
              const link = document.createElement('a');
              link.href = dataURI;
              link.download = filename;
              link.style.display = 'none';
              document.body.appendChild(link);
              link.click();
              // Clean up
              document.body.removeChild(link);
            }

            window.addEventListener("DOMContentLoaded", () => {
              const capturedImage = document.getElementById("captured-image");
              let cropper = new Cropper(capturedImage,  {
                aspectRatio: NaN,
                viewMode: 1,
                autoCrop: false,
                responsive: true,
                ready: () => {
                  this["croppable"] = true;
                }
              });
              capturedImage.addEventListener("cropend", () => {
                const canvas = cropper.getCroppedCanvas();
                const croppedImage = canvas.toDataURL();
                capturedImage.src = croppedImage;
                cropper.destroy();
                showMarkerArea(capturedImage);
              });
            });
          </script>
        </body>
      </html>
    `;
  }

  function openInNewTab(htmlCode, track) {
    const newTab = window.open();
    newTab.document.open();
    newTab.document.write(htmlCode);
    newTab.document.close();
    newTab.addEventListener('beforeunload', () => {
      track.stop();
    });
  }

  function handleError(err) {
    console.error(Drupal.t("Can't access screen:"), err);
    // Check if the error is due to the user canceling the screen sharing prompt.
    if (err.name === 'NotAllowedError' || err.name === 'AbortError') {
      return;
    }
    alert(Drupal.t('An error occurred while trying to capture the screen. Please try again.'));
  }

}(jQuery, Drupal, drupalSettings, once));
