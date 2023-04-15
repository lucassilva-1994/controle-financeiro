<p>Olá {{ $name }}, vimos que você solicitou redefinição de senha.</p>
<p>Para redefinifir a senha basta acessar o link abaixo, mas atenção, esse
    link expira em 24 horas, caso você acesse após 24 horas você deverá solicitar
    um novo reset de senha.
</p>
<p><a href="{{ env('APP_URL').'/user/createpassword/'.$token }}">Resetar senha</a></p>
