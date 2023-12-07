// Toast Alert 
const showTost = (msg, isSuccess = true) => {
    let style = isSuccess ? {
        background: "linear-gradient(to right, #00b09b, #96c93d)",
    } : {
        background: "linear-gradient(to right, #ff5f6d, #ffc371)",
    };
    Toastify({
        text: msg,
        duration: 3000,
        style: style
    }).showToast();
}



