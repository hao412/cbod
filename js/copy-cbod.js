jQuery(document).ready(function(){

    let alertTimeout = function (mymsg,mymsecs){
        let myelement = document.createElement("div");
        myelement.setAttribute("style","background-color:#cce5ff; opacity: 0.5; width: 450px;height: 100px;position: absolute;top:0;bottom:0;left:0;right:0;margin:auto;border: 2px solid #b8daff;font-size:15px;font-weight:bold;display: flex; align-items: center; justify-content: center; text-align: center;");
        myelement.innerHTML = mymsg;
        setTimeout(function(){myelement.parentNode.removeChild(myelement);} , mymsecs);
        document.body.appendChild(myelement);
    }

    jQuery('.data-copy').on("click", function(e){
        e.preventDefault();
        let textToCopy  = jQuery(this).data('clipboardtext');

        if (textToCopy !=''){
            navigator.clipboard.writeText(textToCopy).then(() => {console.log(`Copied "${textToCopy}" to clipboard`);}).catch((err) => {console.error('Could not copy text: ', err);});
            let alertMsg = textToCopy + ' ' + ' 클립보드에 복사되었습니다';        
            alertTimeout(alertMsg,1800);
        } else {
            alertTimeout('클릭보드에 복사할 데이터가 없습니다',1500);
        }

    });

    jQuery('.data-copy-all').on("click", function(e){
        e.preventDefault();

        let billingText = jQuery('.billing-all').data('clipboardtext');
        let shippingText = jQuery('.shipping-all').data('clipboardtext');
        let textToCopy=  billingText + '\t' + shippingText;

        if (textToCopy !=''){
            navigator.clipboard.writeText(textToCopy).then(() => {console.log(`Copied "${textToCopy}" to clipboard`);}).catch((err) => {console.error('Could not copy text: ', err);});
            let alertMsg = textToCopy + ' ' + ' 클립보드에 복사되었습니다';
            alertTimeout(alertMsg,1800);
        } else {
            alertTimeout('클릭보드에 복사할 데이터가 없습니다',1500);
        }

    });
});

