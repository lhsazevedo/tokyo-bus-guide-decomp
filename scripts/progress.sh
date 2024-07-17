#!/bin/bash

LC_NUMERIC=C

matched_lines=$(grep -lE "SECTION\s+P" src/asm/matched/*.src | xargs cat | grep -vE ".IMPORT|.EXPORT" | wc -l)
decompiled_lines=$(grep -lE "SECTION\s+P" src/asm/decompiled/*.src | xargs cat | grep -vE ".IMPORT|.EXPORT" | wc -l)
remaining_lines=$(grep -lE "SECTION\s+P" src/asm/*.src | xargs cat | grep -vE ".IMPORT|.EXPORT" | wc -l)

decompiled_total=$((matched_lines + decompiled_lines))
total_lines=$((decompiled_total + remaining_lines))

if [ $total_lines -ne 0 ]; then
    progress_percentage=$(echo "scale=4; $decompiled_total / $total_lines * 100" | bc)
    progress_percentage=$(printf "%.2f" $progress_percentage)
else
    progress_percentage=0
fi

echo "Matched lines: $matched_lines"
echo "Decompiled lines: $decompiled_lines"
echo "Decompiled total: $decompiled_total"
echo "Total lines: $total_lines"
echo "Progress percentage: $progress_percentage%"

# Update README file with progress
readme_file="README.md"

if grep -q "Decompilation Progress:" "$readme_file"; then
    sed -i "s/Decompilation Progress: [0-9.]\+%/Decompilation progress: $progress_percentage%/" "$readme_file"
    echo "README file updated with current progress."
else
    echo "Progress not found in README file!"
fi
