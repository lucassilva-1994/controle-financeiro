
<div style="font-size: 25px;">Olá {{ucwords($nome)}}, recebemos sua solicitação para alterar senha,
    <a href="{{ route('newpassword.user', $token) }}" target="_blank">clique aqui</a> 
    para configurar uma nova senha de acesso.<br/>
    <span>Dados para acesso:</span><br/>
    <span><strong>Usuário:</strong> {{$user}} <strong>Senha: </strong> Nova senha</span>
</div>

