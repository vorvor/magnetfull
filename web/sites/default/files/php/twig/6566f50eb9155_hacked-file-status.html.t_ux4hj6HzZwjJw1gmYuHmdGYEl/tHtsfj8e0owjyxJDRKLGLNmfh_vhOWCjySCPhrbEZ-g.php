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

/* modules/contrib/hacked/templates/hacked-file-status.html.twig */
class __TwigTemplate_3309b5a3053367722a128560eb8a48e4 extends \Twig\Template
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
        // line 1
        echo "<div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["status"] ?? null), "attributes", [], "any", false, false, true, 1), "addClass", [0 => "project-update__status"], "method", false, false, true, 1), 1, $this->source), "html", null, true);
        echo ">";
        // line 2
        if (twig_get_attribute($this->env, $this->source, ($context["status"] ?? null), "label", [], "any", false, false, true, 2)) {
            // line 3
            echo "<span>";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["status"] ?? null), "label", [], "any", false, false, true, 3), 3, $this->source), "html", null, true);
            echo "</span>";
        }
        // line 5
        echo "  <span class=\"project-update__status-icon\">
    ";
        // line 6
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["status"] ?? null), "icon", [], "any", false, false, true, 6), 6, $this->source), "html", null, true);
        echo "
  </span>
</div>

<div class=\"project-update__title\">";
        // line 11
        if (twig_get_attribute($this->env, $this->source, ($context["file"] ?? null), "url", [], "any", false, false, true, 11)) {
            // line 12
            echo "<a href=\"";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["file"] ?? null), "url", [], "any", false, false, true, 12), 12, $this->source), "html", null, true);
            echo "\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["file"] ?? null), "name", [], "any", false, false, true, 12), 12, $this->source), "html", null, true);
            echo "</a>";
        } else {
            // line 14
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["file"] ?? null), "name", [], "any", false, false, true, 14), 14, $this->source), "html", null, true);
        }
        // line 16
        echo "</div>";
    }

    public function getTemplateName()
    {
        return "modules/contrib/hacked/templates/hacked-file-status.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  72 => 16,  69 => 14,  62 => 12,  60 => 11,  53 => 6,  50 => 5,  45 => 3,  43 => 2,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/hacked/templates/hacked-file-status.html.twig", "/app/web/modules/contrib/hacked/templates/hacked-file-status.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 2);
        static $filters = array("escape" => 1);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape'],
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
