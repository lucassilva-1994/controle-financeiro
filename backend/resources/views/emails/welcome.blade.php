<p>Olá {{ $name }}, seja bem-vindo ao sistema de controle financeiro</p>
<p>A próxima etapa agora é você configurar uma senha de acesso,
    <a href="{{env('APP_URL').'user/createpassword/'.$token }}">Clique aqui</a> para configurar uma senha.
</p>
<p>Obs: Esse link é válido por 24 horas a partir do momento em que você chegou esse e-mail.</p>
