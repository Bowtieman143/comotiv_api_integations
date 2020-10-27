jQuery(document).ready(function($) {

     
  


    /* Vidoask Event Listener */
    const root = document.getElementById("root");
    const isVideoaskMessage = message =>
    message.origin === "https://ask.comotiv.com" &&
    message.data &&
    message.data.type &&
    message.data.type.startsWith("videoask_");

    let share_id = "";
    let share_url = "";
    let question_id = "";
    


    window.addEventListener("message", message => {
        if (!isVideoaskMessage(message)) {
            return;
        }

        console.log("got videoask message", message.data);

        const { type } = message.data;

        if (type === "videoask_submitted") {
            //root.innerText = "VideoAsk submitted!";


            /* 
            var myHeaders = new Headers();
            myHeaders.append("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvY29tb3Rpdi5sb2NhbCIsImlhdCI6MTYwMTA0NjI5MywibmJmIjoxNjAxMDQ2MjkzLCJleHAiOjE2MDE2NTEwOTMsImRhdGEiOnsidXNlciI6eyJpZCI6MX19fQ.PfHhBUHzSzxhrKGbar4eJ0S6z255IwC2YXsrimi2Jaw");
            myHeaders.append("Content-Type", "application/json");
            
            var raw = JSON.stringify({"post":148,"author_name":"Dennis Dinsmore","author_email":"dennis@lightsoutinteractive.com","content":"<iframe src='https://ask.comotiv.com/ciopajexknjj1cyuke7tc9a0le8cp019vl2liwbx' allow='camera; microphone; autoplay; encrypted-media;' width='100%' height='650px' frameborder='0'></iframe>"});
            
            var requestOptions = {
              method: 'POST',
              headers: myHeaders,
              body: raw,
              redirect: 'manual'
            };
            
            fetch("https://comotiv.local/wp-json/wp/v2/comments/", requestOptions)
            .then(response => response.text())
            .then(result => console.log(result))
            .catch(error => console.log('error', error));           
            */
           
           
           //location.reload(true);
            
        }

        if (type === "videoask_question_submitted") {
        
          

          // Hit VideoAsk API
          // Return Share_URL




        }

    });
    

});

