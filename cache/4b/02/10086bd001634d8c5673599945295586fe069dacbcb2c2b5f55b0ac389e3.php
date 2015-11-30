<?php

/* login.tmpl */
class __TwigTemplate_4b0210086bd001634d8c5673599945295586fe069dacbcb2c2b5f55b0ac389e3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("base.html");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'header' => array($this, 'block_header'),
            'content' => array($this, 'block_content'),
            'footer' => array($this, 'block_footer'),
            'scripts' => array($this, 'block_scripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "Login";
    }

    // line 5
    public function block_header($context, array $blocks = array())
    {
        echo " ";
    }

    // line 7
    public function block_content($context, array $blocks = array())
    {
        // line 8
        echo "    <div class = \"body-login\" align = \"center\">
        <div class = \"login-container\">
            <div class = \"login-wrapper\">
                <div class = \"login-logo\"></div>
                <div class = \"login-form\">
                    <form id = \"form-login\">
                        <fieldset class=\"\">
                            <label class=\"\">
                                <span class=\"fa-stack fa-lg\">
                                    <i class=\"fa fa-square-o fa-stack-2x\"></i>
                                    <i class=\"fa fa-user fa-stack-1x\"></i>
                                </span>
                            </label>
                            <input class=\"\" type=\"text\" value=\"\" name=\"username\" id=\"uname\" placeholder=\"Username\" autocomplete=\"off\" required />
                        </fieldset>
                        <fieldset>
                            <label class=\"\">
                                <span class=\"fa-stack fa-lg\">
                                    <i class=\"fa fa-square-o fa-stack-2x\"></i>
                                    <i class=\"fa fa-key fa-stack-1x\"></i>
                                </span>
                            </label>
                            <input class=\"\" type=\"password\" value=\"\" name=\"password\" id=\"upass\" placeholder=\"Password\" autocomplete=\"off\" required />

                        </fieldset>
                        <fieldset>
                            <span class = \"error-msg\">
                            </span>
                        </fieldset>      
                        
                        <fieldset>
                            <!--<span class = \"login-remember-block\">-->
                                <!--<input type=\"checkbox\" name=\"remember\" id=\"login-remember\" value = \"true\">-->
                                <!--<label for=\"login-remember\"></label>-->
                            <!--</span>-->
                            <!--<span class = \"login-remember-text\">Remember?</span>-->
                            <button class = \"login-submit\" type = \"submit\" >Submit</button>
                        </fieldset>
                        <!-- <fieldset class = \"login-forgot\">
                            Forgot Your Password?
                        </fieldset> -->
                        
                    </form>
                </div>
            </div>
            <!--<div class = \"login-register\">-->
                <!--Not a registered user yet? <span class = \"login-register-link\"> Sign up now!</span>-->
            <!--</div>-->
        </div>
            
    </div>
";
    }

    // line 61
    public function block_footer($context, array $blocks = array())
    {
    }

    // line 63
    public function block_scripts($context, array $blocks = array())
    {
        // line 64
        echo "    <script type=\"text/javascript\" src=";
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("jquery-2.1.0.min.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 65
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.core.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 66
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.core.analytics.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 67
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.loader.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 68
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("invokeService.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 69
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("form.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 70
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("login.js"));
        echo "></script>
";
    }

    public function getTemplateName()
    {
        return "login.tmpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  143 => 70,  139 => 69,  135 => 68,  131 => 67,  127 => 66,  123 => 65,  118 => 64,  115 => 63,  110 => 61,  55 => 8,  52 => 7,  46 => 5,  40 => 3,  11 => 1,);
    }
}
