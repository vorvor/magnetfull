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

/* themes/mapvr/comment.html.twig */
class __TwigTemplate_41435a28c54cf34b4bc7404abd917ce4 extends \Twig\Template
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
        // line 69
        if (($context["threaded"] ?? null)) {
            // line 70
            echo "  ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("claro/classy.indented"), "html", null, true);
            echo "
";
        }
        // line 73
        $context["classes"] = [0 => "comment", 1 => "js-comment", 2 => (((        // line 76
($context["status"] ?? null) != "published")) ? (($context["status"] ?? null)) : ("")), 3 => ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,         // line 77
($context["comment"] ?? null), "owner", [], "any", false, false, true, 77), "anonymous", [], "any", false, false, true, 77)) ? ("by-anonymous") : ("")), 4 => (((        // line 78
($context["author_id"] ?? null) && (($context["author_id"] ?? null) == twig_get_attribute($this->env, $this->source, ($context["commented_entity"] ?? null), "getOwnerId", [], "method", false, false, true, 78)))) ? ((("by-" . $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["commented_entity"] ?? null), "getEntityTypeId", [], "method", false, false, true, 78), 78, $this->source)) . "-author")) : (""))];
        // line 81
        echo "<article";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 81), 81, $this->source), "html", null, true);
        echo ">
  ";
        // line 87
        echo "  <mark class=\"hidden\" data-comment-timestamp=\"";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["new_indicator_timestamp"] ?? null), 87, $this->source), "html", null, true);
        echo "\"></mark>

  <div";
        // line 89
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["content_attributes"] ?? null), "addClass", [0 => "content"], "method", false, false, true, 89), 89, $this->source), "html", null, true);
        echo ">

    ";
        // line 91
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["content"] ?? null), 91, $this->source), "html", null, true);
        echo " (";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["submitted"] ?? null), 91, $this->source), "html", null, true);
        echo ")
  </div>
</article>
";
    }

    public function getTemplateName()
    {
        return "themes/mapvr/comment.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 91,  63 => 89,  57 => 87,  52 => 81,  50 => 78,  49 => 77,  48 => 76,  47 => 73,  41 => 70,  39 => 69,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/mapvr/comment.html.twig", "/home/wabisabe/magnet.wabisabee.com/web/themes/mapvr/comment.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 69, "set" => 73);
        static $filters = array("escape" => 70);
        static $functions = array("attach_library" => 70);

        try {
            $this->sandbox->checkSecurity(
                ['if', 'set'],
                ['escape'],
                ['attach_library']
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
