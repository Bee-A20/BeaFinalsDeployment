from pathlib import Path
p = Path(r'c:\Users\Bea\BeaFinals\templates\landing_page\index.html.twig')
text = p.read_text(encoding='utf-8')
style_start = text.index('<style>')
style_end = text.index('</style>', style_start) + len('</style>')
style_content = text[style_start+len('<style>'):style_end-len('</style>')].strip()
main_start = text.index('<main id="main">')
script_start = text.rfind('<script>', 0, text.rfind('</body>'))
main_content = text[main_start:script_start].strip()
new = ["{% extends 'base.html.twig' %}", "{% set hide_topbar = true %}", "{% block title %}Pacunla · School Supplies & Stationery{% endblock %}", "{% block page_title %}Home{% endblock %}", "", "{% block stylesheets %}", "    {{ parent() }}", style_content, "{% endblock %}", "", "{% block body %}", "    <a class='skip-link' href='#main'>Skip to content</a>"]
new.extend(main_content.splitlines())
new.append('{% endblock %}')
p.write_text('\n'.join(new), encoding='utf-8')
print('rewritten', p)
