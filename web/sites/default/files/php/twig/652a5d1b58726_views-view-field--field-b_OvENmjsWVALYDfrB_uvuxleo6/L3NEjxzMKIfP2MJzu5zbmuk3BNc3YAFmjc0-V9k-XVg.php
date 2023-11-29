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

/* themes/mapvr/views-view-field--field-bottom-notes.html.twig */
class __TwigTemplate_1e3c149d6080118b0bd00015e9bab709 extends \Twig\Template
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
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 23
        echo "
";
        // line 24
        if ((($context["output"] ?? null) == "No")) {
            // line 25
            echo "    <img width=\"25\" src=\"/themes/mapvr/cross.png\">
";
        }
        // line 27
        echo "
";
        // line 28
        if ((($context["output"] ?? null) == "Yes")) {
            // line 29
            echo "    <img width=\"35\" src=\"/themes/mapvr/check.png\">
";
        }
    }

    public function getTemplateName()
    {
        return "themes/mapvr/views-view-field--field-bottom-notes.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  53 => 29,  51 => 28,  48 => 27,  44 => 25,  42 => 24,  39 => 23,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/mapvr/views-view-field--field-bottom-notes.html.twig", "/home/wabisabe/magnet.wabisabee.com/web/themes/mapvr/views-view-field--field-bottom-notes.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 24);
        static $filters = array();
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                [],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
