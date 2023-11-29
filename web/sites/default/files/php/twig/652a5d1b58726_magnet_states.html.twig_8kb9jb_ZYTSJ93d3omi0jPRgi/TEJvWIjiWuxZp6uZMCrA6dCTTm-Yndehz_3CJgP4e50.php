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

/* modules/magnet/templates/magnet_states.html.twig */
class __TwigTemplate_d0f26e312f97e2f9d562ccea982e9102 extends \Twig\Template
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
        echo "<div id=\"states-wrapper\">
\t<div id=\"states\">
\t";
        // line 3
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["states_list"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["state"]) {
            // line 4
            echo "\t\t<div class=\"state ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["state"], "class", [], "any", false, false, true, 4), 4, $this->source), "html", null, true);
            echo "\">
\t\t\t<div class=\"date\">
\t\t\t\t\t";
            // line 6
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["state"], "deadline", [], "any", false, false, true, 6), 6, $this->source), "html", null, true);
            echo "
\t\t\t</div>
\t\t\t<div class=\"name\">
\t\t\t\t";
            // line 9
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["state"], "state", [], "any", false, false, true, 9), 9, $this->source));
            echo "
\t\t\t</div>
\t\t\t<div class=\"worker\">
\t\t\t\t";
            // line 12
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["state"], "worker", [], "any", false, false, true, 12), 12, $this->source), "html", null, true);
            echo "
\t\t\t</div>
\t\t</div>
\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['state'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        echo "\t</div>
\t<div id=\"state-buttons\">
\t\t";
        // line 18
        if ((($context["user_had_permission"] ?? null) == 1)) {
            // line 19
            echo "\t\t\t";
            if (((($context["phase"] ?? null) == "finished") || (($context["phase"] ?? null) == "init"))) {
                // line 20
                echo "\t\t\t\t<div id=\"pickup\">
\t\t\t\t\t<img src=\"/core/misc/throbber-active.gif\" style=\"display: none;\" class=\"loader\">
\t\t\t\t\t<a href=\"/magnet/setstate/";
                // line 22
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["nid"] ?? null), 22, $this->source), "html", null, true);
                echo "/";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["next_state"] ?? null), 22, $this->source), "html", null, true);
                echo "\">Pickup for ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["next_state"] ?? null), 22, $this->source), "html", null, true);
                echo "</a>
\t\t\t\t</div>
\t\t\t";
            }
            // line 25
            echo "
\t\t\t";
            // line 26
            if ((($context["phase"] ?? null) == "in-progress")) {
                // line 27
                echo "\t\t\t\t<div id=\"pickup\">
\t\t\t\t\t<img src=\"/core/misc/throbber-active.gif\" style=\"display: none;\" class=\"loader\">
\t\t\t\t\t<a href=\"/magnet/setstate/";
                // line 29
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["nid"] ?? null), 29, $this->source), "html", null, true);
                echo "/";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["next_state"] ?? null), 29, $this->source), "html", null, true);
                echo "\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["next_state"] ?? null), 29, $this->source), "html", null, true);
                echo "</a>
\t\t\t\t</div>
\t\t\t\t<div id=\"drop-state\">
\t\t\t\t<img src=\"/core/misc/throbber-active.gif\" style=\"display: none;\" class=\"drop-loader\">
\t\t\t\t\t<a href=\"/magnet/dropstate/";
                // line 33
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["nid"] ?? null), 33, $this->source), "html", null, true);
                echo "\">Drop</a>
\t\t\t\t</div>
\t\t\t";
            }
            // line 36
            echo "\t\t";
        }
        // line 37
        echo "\t</div>
</div>";
    }

    public function getTemplateName()
    {
        return "modules/magnet/templates/magnet_states.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  127 => 37,  124 => 36,  118 => 33,  107 => 29,  103 => 27,  101 => 26,  98 => 25,  88 => 22,  84 => 20,  81 => 19,  79 => 18,  75 => 16,  65 => 12,  59 => 9,  53 => 6,  47 => 4,  43 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/magnet/templates/magnet_states.html.twig", "/home/wabisabe/magnet.wabisabee.com/web/modules/magnet/templates/magnet_states.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 3, "if" => 18);
        static $filters = array("escape" => 4, "raw" => 9);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['for', 'if'],
                ['escape', 'raw'],
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
