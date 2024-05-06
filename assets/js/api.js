function linkedinApi() {
    console.log("Hello from file2.js");

    var companyId = "77vweghg2svs06"; // Replace with your company's LinkedIn ID
    var accessToken = "13lc9yNlvALjaLwz"; // Replace with your access token

    var apiUrl = "https://api.linkedin.com/v2/shares?count=1&owners=urn:li:organization:" + companyId;

    $.ajax({
        url: apiUrl,
        headers: {
            'Authorization': 'Bearer ' + accessToken
        },
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            // Parse and display the latest publication
            var latestPublication = response.elements[0];
            var publicationContent = "<h2>" + latestPublication.text + "</h2>";
            $("#publications").html(publicationContent);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching data from LinkedIn API: " + error);
        }
    })
}