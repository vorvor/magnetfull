import { Plugin } from 'ckeditor5/src/core';
import { ButtonView } from 'ckeditor5/src/ui';
import icon from '../../../../icons/screenshot.svg';

export default class Screenshot extends Plugin {
  init() {
    const editor = this.editor;

    const buttonFactory = function () {
      const button = new ButtonView();

      button.set(
        {
          label: 'Screenshot',
          icon: icon,
          tooltip: true,
        }
      );
      const schema = editor.model.schema;

      schema.register('screenshot', {
        // Behaves like a self-contained object (e.g. an image).
        isObject: true,
        // Allow in places where other blocks are allowed (e.g. directly in the root).
        allowWhere: '$text',
        isInline: true,
        allowAttributes: ['class', 'id'],
      });
      const configConversion = {
        model: {
          name: 'screenshot',
          attributes: [ 'id' ]
        },
        view: {
          name: 'div',
          classes: ['screenshot'],
        },
      };
      editor.conversion.for('downcast').elementToElement(configConversion);
      editor.conversion.for('upcast').elementToElement(configConversion);

      const executeHandler = () => {
        this.config = editor.config.get('screenshot');
        this.config.id = (Math.random() + 1).toString(36).substring(7);
        captureScreen(this.config);
      }
      button.on('execute', executeHandler);

      return button;
    };

    const captureScreen = function(config) {
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

    const handleStream = function(stream, config) {
      const track = stream.getVideoTracks()[0];
      let imageCapture = new ImageCapture(track);
      imageCapture.grabFrame().then((bitmap) => processFrame(bitmap, track, config)).catch(handleError);
    }
    const processFrame = function(bitmap, track, config) {
      const canvas = document.createElement('canvas');
      drawImageOnCanvas(bitmap, canvas);
      const capture = document.createElement('img');
      capture.id = 'captured-image';
      capture.src = canvas.toDataURL();
      capture.width = 2;
      document.body.appendChild(capture);
      let markerArea = new markerjs2.MarkerArea(capture);
      markerArea.settings.displayMode = 'popup';
      markerArea.addEventListener( "render", event => {
        capture.src = event.dataUrl;
      });
      markerArea.show();
      markerArea.addEventListener("close", (event) => {
        const base64Image = capture.src;
        capture.remove();
        config.screenshot = base64Image;
        if (config.url != undefined && base64Image != '') {
          fetch(config.url, {
            method: "POST",
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(config)
          })
            .then(response => response.json())
            .then(data => {
              if (data.url) {
                const currentDate = new Date();
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth() + 1;
                const day = currentDate.getDate();
                const hours = currentDate.getHours();
                const minutes = currentDate.getMinutes();

                let img = `<a href="${data.url}" class="screenshot-popup" title="Screenshot"><img src="${data.url}" alt="Screenshot ${day}/${month}/${year} - ${hours}:${minutes}" data-align="left"/></a>`;
                const viewFragment = editor.data.processor.toView(img);
                const modelFragment = editor.data.toModel(viewFragment);

                // Change the model using the model writer.
                const write = writer => {
                  const screenshot = writer.createElement('screenshot');
                  writer.append(modelFragment,screenshot);
                  editor.model.insertContent(screenshot);
                }
                editor.model.change(write);
                let selector = document.querySelector('.screenshot');
                selector.classList.remove('screenshot');
              }
            })
            .catch(error => {
              console.error('Error:', error);
            });
        }
        else {
          const filename = "screenshot.png";
          saveImageToFile(base64Image, filename);
          selector.innerHTML = '';
        }
      });
    }

     const saveImageToFile = function(dataURI, filename) {
      const link = document.createElement('a');
      link.href = dataURI;
      link.download = filename;
      link.style.display = 'none';
      document.body.appendChild(link);
      link.click();
      // Clean up
      document.body.removeChild(link);
    }
    const drawImageOnCanvas = function(bitmap, canvas) {
      canvas.width = bitmap.width;
      canvas.height = bitmap.height;
      const context = canvas.getContext('2d');
      context.drawImage(bitmap, 0, 0, bitmap.width, bitmap.height);
    }
    const handleError = function(err) {
      console.error(Drupal.t("Can't access screen:"), err);
      // Check if the error is due to the user canceling the screen sharing prompt.
      if (err.name === 'NotAllowedError' || err.name === 'AbortError') {
        return;
      }
      alert(Drupal.t('An error occurred while trying to capture the screen. Please try again.'));
    }

    editor.ui.componentFactory.add('screenshot', buttonFactory);
  }

}
