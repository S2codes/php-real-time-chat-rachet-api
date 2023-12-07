
HttpRequest = function (url, data, callback) {

    $.ajax({
        url: url,
        method: "POST",
        data: data,
        success: function (data) {
            callback(data)
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Error submitting the form. Please try again.');
        }
    })

}


HttpDataRequest = function (url, data, callback) {

    $.ajax({
        url: url,
        type: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function (data) {
            callback(data)
        }
    })

}
