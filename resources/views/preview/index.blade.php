
<html>
    <head>
      <style>
        .tshirt
        {
          position:absolute;
          top: 10px;
          left: 10px;
          z-index: 1;
        }
        .estampa
        {
          position:absolute;
          top: 120px;
          left: 180px;
          z-index: 2;
        }
      </style>
    </head>

    <!-- width="578" height="642" -->

    <body>


      <img src="storage/tshirt_base/{{$tshirt}}" class="tshirt" >
     <img src="storage/estampas/{{$estampa}}" class="estampa" width="173" height="192">

    </body>
    </html>
