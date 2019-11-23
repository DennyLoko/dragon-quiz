<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* register.html */
class __TwigTemplate_9e2cc25e994874b922fa6d74b5e8bc666544d4556552c0a59328e719c3ac71c8 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<DOCTYPE html!>
<html>
<head>
<title>Cadastre-se</title>
</head>
<body>

<form method='POST' action=''>
\t
\t<label for='name'>Nome de Usuário:</label>
\t<input type='text' id='name' name='name' placeholder='Username' value='";
        // line 11
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo "'>
\t
\t<label for='email'>Email:</label>
\t<input type='text' id='email' name='email' placeholder='Email' value='";
        // line 14
        echo twig_escape_filter($this->env, ($context["email"] ?? null), "html", null, true);
        echo "'>
\t
\t<label for='password'>Senha:</label>
\t<input type='password' name='password' id='password' placeholder='Senha' value='";
        // line 17
        echo twig_escape_filter($this->env, ($context["password"] ?? null), "html", null, true);
        echo "'>
\t
\t<label for='cpassword'>Confirmar Senha:</label>
\t<input type='password' name='cpassword' id='cpassword' placeholder='Confirmar Senha' value='";
        // line 20
        echo twig_escape_filter($this->env, ($context["cpassword"] ?? null), "html", null, true);
        echo "'>
\t
\t<input type='submit' id='register'/>



</form>

</body>
</html>";
    }

    public function getTemplateName()
    {
        return "register.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 20,  61 => 17,  55 => 14,  49 => 11,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "register.html", "F:\\Laragon\\www\\dragon-quiz\\src\\view\\Register.html");
    }
}
