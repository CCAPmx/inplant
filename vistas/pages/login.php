<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bootstrap 5 Login form Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="vistas/recursos/css/login.css">
</head>

<body>

    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2 text-white mb-3">BIENVENIDO A LA TECNOLOGIA DE GRANALLADO DE LA INDUSTRIA 4.0:</h1>
                            <h1 class="h2 text-white mb-3">INPLANT - <span class="title-year"></span></h1>
                        </div>

                        <div class="card" id="mycard">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <div class="text-center">
                                        <img src="vistas/recursos/img/avatars/in-plant.jpeg" alt="inplant" class="img-fluid" width="350"/>
                                    </div>
                                    <form class="mb-3 mt-md-4" role="form" method="post" autocomplete="off">
                                        <div class="mb-3">
                                            <label for="txtMail" class="form-label">Usuario</label>
                                            <input class="form-control" type="text" id="txtMail" name="txtMail" placeholder="Ingrese Usuario" required/>
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtPass" class="form-label">Password</label>
                                            <input class="form-control mb-3" type="password" id="txtPass" name="txtPass" placeholder="Ingrese Password" required/>
                                            <small>
                                                <a href="#">Has olvidado tu contraseña?</a>
                                            </small>
                                        </div>
                                        <div>
                                            <label class="form-check">
                                                <input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked>
                                                <span class="form-check-label">
                                                    Recuerdame la proxima vez
                                                </span>
                                            </label>
                                        </div>
                                        <div class="text-center mt-3">
                                            <!-- <a href="inicio" class="btn btn-outline-primary">Iniciar sesión</a> -->
                                            <button type="submit" class="btn btn-outline-primary">Iniciar sesión</button>
                                        </div>

                                        <?php
                                            $login = new ControladorUsuarios();
                                            $login->ctrIngresoUsuario();
                                        ?>        

                                    </form>
                                </div>
                                <div class="lersan-logo">
                                    <img src="vistas/recursos/img/avatars/lersan.png" alt="Lersan" width="200"/>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="particles-js"></div>
    <script src="vistas/recursos/js/particles.min.js"></script>
    <script>
        particlesJS({
            "particles": {
                "number": {
                    "value": 85,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg",
                        "width": 100,
                        "height": 100
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#ffffff",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 11,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 400,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        })

        /**<<<< actualizar año >>>>**/
        const titleYearElement = document.querySelector('.title-year');
        const currentYear = new Date().getFullYear();
        titleYearElement.textContent = currentYear;
        /**<<<< actualizar año >>>>**/
    </script>
</body>

</html>