fonts=$(fc-list | grep -i dejavu | cut -d ':' -f1)

for font in $fonts; do
    php load_font.php "DejaVu Sans" $font
done
