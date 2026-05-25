from pathlib import Path

for file_path in [r'c:\Users\Bea\BeaFinals\templates\landing_page\about.html.twig', r'c:\Users\Bea\BeaFinals\templates\landing_page\contact.html.twig']:
    p = Path(file_path)
    text = p.read_text(encoding='utf-8')

    title_start = text.index('<title>') + len('<title>')
    title_end = text.index('</title>', title_start)
    title = text[title_start:title_end].strip()

    style_start = text.index('<style>') + len('<style>')
    style_end = text.index('</style>', style_start)
    styles = text[style_start:style_end].strip()

    main_start = text.index('<main id="main">')
    footer_start = text.rfind('<footer>')
    if footer_start != -1 and footer_start > main_start:
        body_end = footer_start
    else:
        body_end = text.rfind('</main>') + len('</main>')

    skip_link = None
    skip_pos = text.find('<a class="skip-link"')
    if skip_pos == -1:
        skip_pos = text.find("<a class='skip-link'")
    if skip_pos != -1 and skip_pos < main_start:
        end = text.find('</a>', skip_pos) + len('</a>')
        skip_link = text[skip_pos:end].strip()

    body_content = text[main_start:body_end].strip()
    page_title = 'About' if 'About' in title else 'Contact' if 'Contact' in title else 'Home'

    output_lines = ["{% extends 'base.html.twig' %}", "{% set hide_topbar = true %}", f"{% block title %}{title}{'% endblock %'}"]
    output_lines.append(f"{% block page_title %}{page_title}{'% endblock %'}")
    output_lines.append("")
    output_lines.append("{% block stylesheets %}")
    output_lines.append("    {{ parent() }}")
    output_lines.append(styles)
    output_lines.append("{% endblock %}")
    output_lines.append("")
    output_lines.append("{% block body %}")
    if skip_link:
        output_lines.append(skip_link)
    output_lines.extend(body_content.splitlines())
    output_lines.append("{% endblock %}")

    p.write_text('\n'.join(output_lines), encoding='utf-8')
    print(f'updated {file_path}')
