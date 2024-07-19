#!/bin/bash

LC_NUMERIC=C

matched_lines=$(grep -lE "SECTION\s+P" src/asm/matched/*.src | xargs cat | grep -vE ".IMPORT|.EXPORT" | wc -l)
decompiled_lines=$(grep -lE "SECTION\s+P" src/asm/decompiled/*.src | xargs cat | grep -vE ".IMPORT|.EXPORT" | wc -l)
remaining_lines=$(grep -lE "SECTION\s+P" src/asm/*.src | xargs cat | grep -vE ".IMPORT|.EXPORT" | wc -l)

decompiled_total=$((matched_lines + decompiled_lines))
total_lines=$((decompiled_total + remaining_lines))

if [ $total_lines -eq 0 ]; then
    echo "Total lines is 0!"
    exit
fi

progress_percentage=$(echo "scale=4; $decompiled_total / $total_lines * 100" | bc)
progress_percentage=$(printf "%.1f" $progress_percentage)
progress_percentage_int=${progress_percentage%.*}

echo "Matched lines: $matched_lines"
echo "Decompiled lines: $decompiled_lines"
echo "Decompiled total: $decompiled_total"
echo "Total lines: $total_lines"
echo "Progress percentage: $progress_percentage%"

# Update README file with progress
readme_file="README.md"

if ! grep -q "https://img.shields.io/badge/decompiled-" "$readme_file"; then
    echo "Progress badge not found in README file!"
    exit 1
fi

sed -i "s/https:\/\/img.shields.io\/badge\/decompiled-[0-9.]\+/https:\/\/img.shields.io\/badge\/decompiled-$progress_percentage/" "$readme_file"
echo "README file progress badge updated."

if ! grep -q "Decompilation progress:" "$readme_file"; then
    echo "Progress not found in README file!"
    exit 1
fi

sed -i "s/Decompilation progress: [0-9.]\+%/Decompilation progress: $progress_percentage%/" "$readme_file"
echo "README file progress updated."

if ! grep -q "https://progress-bar.dev/" "$readme_file"; then
    echo "Progress bar not found in README file!"
    exit 1
fi

sed -i "s/https:\/\/progress-bar.dev\/[0-9]\+/https:\/\/progress-bar.dev\/$progress_percentage_int/" "$readme_file"
echo "README progress bar updated."