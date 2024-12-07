<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login_user.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        nav {
            position: absolute;
            top: 0;
            width: 100%;
            background-color: #585858;
            color: white;
            padding: 10px 20px;
            background-color: rgba(0, 0, 0, 0.8);
        }

        nav .logo a {
            text-decoration: none;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .login-container,
        .admin-container {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .links {
            margin-top: 20px;
        }

        .links a {
            color: #4CAF50;
            text-decoration: none;
            font-size: 14px;
            margin: 0 10px;
            transition: color 0.3s;
        }

        .links a:hover {
            color: #388e3c;
        }

        .admin-container {
            background-color: #cccccc;
            border: 1px solid #c7c3c3;
        }

        .admin-container h1 {
            color: #000000;
        }

        .btn-back {
            display: inline-block;
            margin-top: 15px;
            color: #000000;
            text-decoration: none;
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: color 0.3s;
        }

        .btn-back:hover {
            color: #303030;
        }

        /* Animações */
        .login-container,
        .admin-container {
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.3s ease, transform 0.3s ease;
            display: none;
        }

        .login-container.active,
        .admin-container.active {
            display: block;
            opacity: 1;
            transform: scale(1);
        }

        /* Responsividade */
        @media (max-width: 768px) {
            nav .logo a {
                font-size: 20px;
            }

            .login-container,
            .admin-container {
                padding: 20px;
            }

            h1 {
                font-size: 20px;
            }

            .btn {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <nav>
        <div class="logo">
            <a href="index.html"> Jacuípe </a>
        </div>
    </nav>

    <!-- Botão para acessar o login administrativo -->
    <a href="#" class="btn" id="admin-access-btn">Acesso Administrativo</a>

    <!-- Contêiner de Login Padrão -->
    <div class="login-container active" id="login-container">
        <h1>Login</h1>
        <form action="php/login.php" method="POST" onsubmit="return validarFormulario('email', 'senha')">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
        <div class="links">
            <a href="cad_user.html">Criar uma conta</a>
            <a href="esq_senha.html">Esqueceu a senha?</a>
        </div>
    </div>

    <!-- Contêiner de Login Administrativo -->
    <div class="admin-container hidden" id="admin-login">
        <h1>Acesso Administrativo</h1>
        <form action="php/login.php" method="POST" onsubmit="return validarFormulario('admin-email', 'admin-senha')">
            <div class="form-group">
                <label for="admin-email">Email:</label>
                <input type="email" id="admin-email" name="email" required>
            </div>
            <div class="form-group">
                <label for="admin-senha">Senha:</label>
                <input type="password" id="admin-senha" name="senha" required>
            </div>
            <button type="submit" style="background-color: #4CAF50; color: white;">Entrar</button>
        </form>
        <button class="btn-back" id="back-to-login">Voltar ao Login Padrão</button>
    </div>

    <script>
        // Referências aos elementos
        const adminAccessBtn = document.getElementById('admin-access-btn');
        const loginContainer = document.getElementById('login-container');
        const adminLogin = document.getElementById('admin-login');
        const backToLoginBtn = document.getElementById('back-to-login');

        // Alternar para formulário administrativo
        adminAccessBtn.addEventListener('click', (e) => {
            e.preventDefault();
            loginContainer.classList.remove('active'); // Ocultar formulário de login padrão
            adminLogin.classList.add('active'); // Mostrar formulário administrativo
        });

        // Voltar para o formulário de login padrão
        backToLoginBtn.addEventListener('click', () => {
            adminLogin.classList.remove('active'); // Ocultar formulário administrativo
            loginContainer.classList.add('active'); // Mostrar formulário de login padrão
        });

        // Validação de formulário genérica
        function validarFormulario(emailId, senhaId) {
            const email = document.getElementById(emailId).value.trim();
            const senha = document.getElementById(senhaId).value.trim();

            if (!email || !senha) {
                alert('Os campos não podem estar vazios ou conter apenas espaços em branco.');
                return false; // Impede o envio do formulário
            }
            return true; // Permite o envio do formulário
        }
    </script>

    <style>
        .hidden {
            display: none;
        }

        .active {
            display: block;
        }

        .login-container,
        .admin-container {
            margin: 20px;
        }
    </style>
</body>

</html>