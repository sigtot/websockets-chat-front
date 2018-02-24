function message(msg) {
  $("#chat-box").append(msg);
}

var socket;
function connect(){
  try{

    var host = "ws://159.65.58.116:8080";
    socket = new WebSocket(host);

    message('<p class="event">Socket Status: '+socket.readyState);

    socket.onopen = function(){
      message('<p class="event">Socket Status: '+socket.readyState+' (open)');
    };

    socket.onmessage = function(msg){
      message('<p class="message">'+msg.data);
    };

    socket.onclose = function(){
      message('<p class="event">Socket Status: '+socket.readyState+' (Closed)');
    }

  } catch(exception){
    message('<p>Error'+exception);
  }
}

$(document).ready(function() {
  if(!("WebSocket" in window)){
    $('#chatLog, input, button, #examples').fadeOut("fast");
    $('<p>Oh no, you need a browser that supports WebSockets. How about <a href="http://www.google.com/chrome">Google Chrome</a>?</p>').appendTo('#container');
  }else {

    //The user has WebSockets

    connect();
  }
});

$("#chat-send-button").click(function(){
  console.log($("#chat-input").val());
  socket.send($("#chat-input").val());
  message('<p class="message your-message">You: '+$("#chat-input").val());
  $("#chat-input").val("");
});