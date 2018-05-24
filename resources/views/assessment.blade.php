<!DOCTYPE html>
<html>
<head>
    <title>Survey Layanan UM</title>
    <link rel="icon" type="image/png" href="img/logoUM.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="css/assessment/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/assessment/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/assessment/flex.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link rel="stylesheet" href="css/assessment/animate.css" media="screen" title="no title"/>
    <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
</head>
<body>
    <img class="backg" src="img/assessment/bg1.jpg">
    <div class="center-logo">
        <img src="img/logo.png">
    </div>
    <h2 align="center" class="style-font title-font-head" id="greeting">Halo</h2>
    <h4 align="center" class="style-font">Bagaimana Layanan Kami?</h4>
    <div class="container">
        <div class="flex-container">
            <div class="flex-item point" onclick="rate(0)">
                <img src="img/assessment/1.svg" width="150px" height="150px">
                <h4 align="center" class="style-font">Excellent</h4>
            </div>
            <div class="flex-item point" onclick="rate(1)">
                <img src="img/assessment/2.svg" width="150px" height="150px">
                <h4 align="center" class="style-font">Good</h4>
            </div>
            <div class="flex-item point" onclick="rate(2)">
                <img src="img/assessment/3.svg" width="150px" height="150px">
                <h4 align="center" class="style-font">Bad</h4>
            </div>
            <div class="flex-item point" onclick="rate(3)">
                <img src="img/assessment/4.svg" width="150px" height="150px">
                <h4 align="center" class="style-font">Very Bad</h4>
            </div>
        </div>
    </div>
    <div id="modal1" class="modal custom-modal">
        <div class="modal-content custom-modal-content">
            <h4>Terima Kasih</h4>
            <p>Terima kasih telah memberikan penilaian terhadap pelayanan kami</p>
        </div>
    </div>
    <footer class="page-footer transparent">
        <div class="container ">
            <div class="center flex-container">
                <div class="foot-sm">
                    <img src="img/assessment/web.png" width="50px" height="50px">
                    <a class="style-font"> www.um.ac.id </a>
                </div>

                <div class="foot-sm">
                    <img src="img/assessment/ig.png" width="50px" height="50px">
                    <a class="style-font"> @universitasnegerimalang </a>
                </div>

                <div class="foot-sm">
                    <img src="img/assessment/fb.png" width="50px" height="50px">
                    <a class="style-font"> Informasi.UM </a>
                </div>
            </div>
        </div>
    </footer>
    <script type="text/javascript" src="js/assessment/jquery.min.js"></script>
    <script type="text/javascript" src="js/assessment/materialize.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="/js/assessment/request.js"></script>
</body>
</html>