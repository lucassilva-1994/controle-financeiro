<div style="font-size: 25px;">
    Seja bem-vindo (a) {{ucwords($nome)}}, 
    <a href="{{ route('validate.user', $token) }}" target="_blank">acesse aqui</a> 
    para ativar sua conta.<br/>
    <span>Dados para acesso:</span><br/>
    <span><strong>Usuário:</strong> {{$user}} <strong>Senha: </strong> Senha informada no cadastro.</span>
</div>
