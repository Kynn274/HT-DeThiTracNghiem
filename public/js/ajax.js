document.addEventListener("DOMContentLoaded", function() {
   const keyframes1 = `
   @keyframes slideIn {
        0% {
            transform: translate(-50%, -150%);
        }
        100% {
            transform: translate(-50%, -50%);
            opacity: 1;
        }
   }
   `;
   const keyframes2 = `
   @keyframes slideOut  {
        0% {
            transform: translate(-50%, -50%);
            opacity: 1;
        }
        100% {
            transform: translate(-50%, 150%);
            opacity: 0;
        }
    }
   `;
   function appendStyle(element, style) {
       const styleElement = document.createElement('style');
       styleElement.type = 'text/css';
       if (styleElement.styleSheet){
            styleElement.styleSheet.cssText = style;
       } else {
            styleElement.appendChild(document.createTextNode(style));
        }
        element.appendChild(styleElement);
    }

    $("#close-signin-btn").click(function() {
        appendStyle(document.head, keyframes2);
        $(".signin-container").css("animation", "slideOut 1s forwards");
        setTimeout(function() {
            $(".signin-container").hide();
        }, 300);
    });
    $("#signin-btn").click(function() {
        console.log("clicked");
        appendStyle(document.head, keyframes1);
        $(".signin-container").css("animation", "slideIn 1s forwards");
        setTimeout(function() {
            $(".signin-container").show();
        }, 300);
    });
});
