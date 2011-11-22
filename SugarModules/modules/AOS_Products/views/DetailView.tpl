{*
*}
<link rel="stylesheet" type="text/css" href="modules/AOS_Products/js/jquery.jqplot.css" />
{{include file=$headerTpl}}
{sugar_include include=$includes}
<div id="{{$module}}_detailview_tabs" 
{{if $useTabs}}
class="yui-navset detailview_tabs"
{{/if}}
>
    {{if $useTabs}}
    {* Generate the Tab headers *}
    {{counter name="tabCount" start=-1 print=false assign="tabCount"}}
    <ul class="yui-nav">
    {{foreach name=section from=$sectionPanels key=label item=panel}}
        {{counter name="tabCount" print=false}}
        <li><a id="tab{{$tabCount}}" href="#tab{{$tabCount}}"><em>{sugar_translate label='{{$label}}' module='{{$module}}'}</em></a></li>
    {{/foreach}}
    </ul>
    {{/if}}
    <div {{if $useTabs}}class="yui-content"{{/if}}>
{{* Loop through all top level panels first *}}
{{counter name="panelCount" print=false start=0 assign="panelCount"}}
{{foreach name=section from=$sectionPanels key=label item=panel}}
{{assign var='panel_id' value=$panelCount}}
<div id='{{$label}}' class='detail view'>
{counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
{{* Print out the panel title if one exists*}}

{{* Check to see if the panel variable is an array, if not, we'll attempt an include with type param php *}}
{{* See function.sugar_include.php *}}
{{if !is_array($panel)}}
    {sugar_include type='php' file='{{$panel}}'}
{{else}}
	
	{{if !empty($label) && !is_int($label) && $label != 'DEFAULT' && !$useTabs}}
	<h4>{sugar_translate label='{{$label}}' module='{{$module}}'}</h4>
	{{/if}}
	{{* Print out the table data *}}
	<table id='detailpanel_{{$smarty.foreach.section.iteration}}' cellspacing='{$gridline}'>
	

	
	{{foreach name=rowIteration from=$panel key=row item=rowData}}
	<tr>
		{{assign var='columnsInRow' value=$rowData|@count}}
		{{assign var='columnsUsed' value=0}}
	    {{foreach name=colIteration from=$rowData key=col item=colData}}
			<td width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].label}}%' scope="row">
				{{if isset($colData.field.customLabel)}}
			       {{$colData.field.customLabel}}
				{{elseif isset($colData.field.label) && strpos($colData.field.label, '$')}}
				   {capture name="label" assign="label"}
				   {{$colData.field.label}}
				   {/capture}
			       {$label|strip_semicolon}:
				{{elseif isset($colData.field.label)}}
				   {capture name="label" assign="label"}
				   {sugar_translate label='{{$colData.field.label}}' module='{{$module}}'}
				   {/capture}
			       {$label|strip_semicolon}:
				{{elseif isset($fields[$colData.field.name])}}
				   {capture name="label" assign="label"}
				   {sugar_translate label='{{$fields[$colData.field.name].vname}}' module='{{$module}}'}
				   {/capture}
			       {$label|strip_semicolon}:
				{{else}}
				   &nbsp;
				{{/if}}
			</td>
			<td width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].field}}%' {{if $colData.colspan}}colspan='{{$colData.colspan}}'{{/if}}>
				{{if $colData.field.customCode || $colData.field.assign}}
					{counter name="panelFieldCount"}
					{{sugar_evalcolumn var=$colData.field colData=$colData}}	
				{{elseif $fields[$colData.field.name] && !empty($colData.field.fields) }}
				    {{foreach from=$colData.field.fields item=subField}}
				        {{if $fields[$subField]}}
				        	{counter name="panelFieldCount"}
				            {{sugar_field parentFieldArray='fields' tabindex=$tabIndex vardef=$fields[$subField] displayType='DetailView'}}&nbsp;
				        {{else}}
				        	{counter name="panelFieldCount"}
				            {{$subField}}
				        {{/if}}
				    {{/foreach}}					    		
				{{elseif $fields[$colData.field.name]}}
					{counter name="panelFieldCount"}
					{{sugar_field parentFieldArray='fields' vardef=$fields[$colData.field.name] displayType='DetailView' displayParams=$colData.field.displayParams typeOverride=$colData.field.type}}
				{{/if}}
			</td>
		{{/foreach}}
	</tr>
	{{/foreach}}
	</table>
{{/if}}
</div>
{if $panelFieldCount == 0}

<script>document.getElementById("{{$label}}").style.display='none';</script>
{/if}
{{/foreach}}
</div></div>
{{include file=$footerTpl}}
{{if $useTabs}}
<script type="text/javascript" src="include/javascript/sugar_grp_yui_widgets.js"></script>
<script type="text/javascript">
var {{$module}}_detailview_tabs = new YAHOO.widget.TabView("{{$module}}_detailview_tabs");
{{$module}}_detailview_tabs.selectTab(0);
</script> 
{{/if}}
