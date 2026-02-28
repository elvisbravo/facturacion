<?php \ = mysqli_connect('localhost', 'root', '', 'facturacion'); \ = mysqli_query(\, 'DESCRIBE ventas'); while(\ = mysqli_fetch_assoc(\)) echo \['Field'] . ' ';
