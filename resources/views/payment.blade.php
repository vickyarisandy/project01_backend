<html>
    <body>
        <button id="pay-button">Bayar</button>
        <pre><div id="result-json">JSON result will appear here after payment:<br></div></pre>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<SB-Mid-client-l-e0s8UdfXPCYDSG>"></script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function(){
                // SnapToken acquired from previous step
                snap.pay('{{$token}}', {
                    // Optional
                    onSuccess: function(result){
                        document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    },
                    // Optional
                    onPending: function(result){
                        document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    },
                    // Optional
                    onError: function(result){
                      document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    }
                });
            };
        </script>
    </body>
</html>
