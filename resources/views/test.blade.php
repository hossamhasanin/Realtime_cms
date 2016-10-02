<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel 5 | WebSockets</title>
</head>
<body>
<div class="container-fluid">
    <div class="row ">
        <div class="col-xs-12">
            <br/>
           <input type="text" id="input" placeholder="Message…" />
            <hr />
            <pre id="output"></pre>

        </div>
    </div>
</div>


<script>
  var host   = 'ws://localhost:8889';
  var socket = null;
  var input  = document.getElementById('input');
  var output = document.getElementById('output');
  var print  = function (message) {
      var samp       = document.createElement('samp');
      samp.innerHTML = message + '\n';
      output.appendChild(samp);

      return;
  };

  input.addEventListener('keyup', function (evt) {
      if (13 === evt.keyCode) {
          var msg = input.value;

          if (!msg) {
              return;
          }

          try {
              socket.send(msg);
              input.value = '';
              input.focus();
          } catch (e) {
              console.log(e);
          }

          return;
      }
  });

  try {
      socket = new WebSocket(host);
      socket.onopen = function () {
          print('connection is opened');
          input.focus();

          return;
      };
      socket.onmessage = function (koko) {
          print(koko.data);

          return;
      };
      socket.onclose = function () {
          print('connection is closed');

          return;
      };
  } catch (e) {
      console.log(e);
  }
</script>
</body>
</html>