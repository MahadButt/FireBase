<!DOCTYPE html>
<html>
    <head>
        <title>Firebase(FCM Token)</title>
        <!-- The core Firebase JS SDK is always required and must be listed first -->
        <link rel="manifest" href="manifest.json">
        <script src="https://www.gstatic.com/firebasejs/7.14.3/firebase.js"></script>
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <!-- TODO: Add SDKs for Firebase products that you want to use
             https://firebase.google.com/docs/web/setup#available-libraries -->
        <script>
            // Your web app's Firebase configuration
            var firebaseConfig = {
                apiKey: "AIzaSyA1_eumktFP1k7Rmf6hpL6MWMOTfuXS-nQ",
                authDomain: "test-3f931.firebaseapp.com",
                databaseURL: "https://test-3f931.firebaseio.com",
                projectId: "test-3f931",
                storageBucket: "test-3f931.appspot.com",
                messagingSenderId: "38915925902",
                appId: "1:38915925902:web:8f758f29f9b4b50d9c66df"
            };
            // Initialize Firebase
            firebase.initializeApp(firebaseConfig);
            const messaging = firebase.messaging();
            // [START request_permission]
            messaging.requestPermission().then(() => {
                console.log('Notification permission granted.');
                if (isTokenSentToServer()) {
                    console.log('Token already sent to server');
                } else {
                    console.log('Sending token to server...');
                    // TODO(developer): Send the current token to your server.
                    getRegisterdToken();

                }
            }).catch(function (err) {
                console.log('Unable to get permission to notify.', err);
            });
            messaging.onMessage((payload) => {
//                console.log('Message received. ', payload.data.click_action);
                var title = payload.data.title;
                var options = {
                    body: payload.data.body,
                    icon: payload.data.icon
//                    data: {
//                        time: new Date(Date.now()).toString(),
//                        click_action: payload.data.click_action
//                    }
                };
                var myNotification = new Notification(title, options);
            });
            function isTokenSentToServer() {
                return window.localStorage.getItem('sentToServer') === '1';
            }
            function getRegisterdToken() {
                messaging.getToken().then((currentToken) => {
                    if (currentToken) {
                        console.log(currentToken);
                        savetoken(currentToken);
                        sendTokenToServer(currentToken);
                        // updateUIForPushEnabled(currentToken);
                    } else {
                        // Show permission request.
                        console.log('No Instance ID token available. Request permission to generate one.');
                        // Show permission UI.
                        // updateUIForPushPermissionRequired();
                        setTokenSentToServer(false);
                    }
                }).catch((err) => {
                    console.log('An error occurred while retrieving token. ', err);
                    // showToken('Error retrieving Instance ID token. ', err);
                    setTokenSentToServer(false);
                });
            }
            function sendTokenToServer(currentToken) {
                setTokenSentToServer(true);
            }
            function setTokenSentToServer(sent) {
                window.localStorage.setItem('sentToServer', sent ? '1' : '0');
            }
            function savetoken(currentToken) {
                $.ajax({
                    type: "POST",
                    url: 'savefcmtoken.php',
                    data: {'token': currentToken},
                    success: function (response)
                    {
                        console.log(response);
                    }
                });
            }
        </script>
    </head>
    <body style="text-align: center">
        <h1>FCM Javascrip Push & Send Push Notification</h1>
            <button id="submit">Send Push Notification To All Devices</button>
    </body>
    <script>
        $("#submit").click(function(){
            $.ajax({
                    type: "GET",
                    url: 'sendpushnotification.php',
                    success:function (response)
                    {
                        var jsonData = JSON.parse(response);
                        if(jsonData.success===1){
                            console.log(jsonData);
                        }
                    },
                    error:function(){
                        alert('error');
                    }
                });
        });
                
    </script>
</html>