import matplotlib.pyplot as plt
from datetime import datetime

dates = [datetime(2022, 3, 27), datetime(2024, 1, 1), datetime(2024, 7, 19), datetime(2024, 11, 1), datetime(2024, 11, 5)]
decompiled_code = [
    0.0, 2.0, 12.6, 14.7, 14.9
]
matched_code = [
    0.0, 1.0, 1.3, 1.3, 1.3
]

fig, ax = plt.subplots()

# Using vibrant colors and highlighting Decompiled Code
ax.plot(dates, decompiled_code, label='Decompiled Code', color='#4659eb', marker='.', markersize=8, linewidth=2.5)
ax.plot(dates, matched_code, label='Matched Code', color='#5a6ae6', marker='.', markersize=8, linestyle='--', linewidth=1.5)

ax.set_title("Matched vs. Decompiled Code Over Time")
ax.set_xlabel("Date")
ax.set_ylabel("Percentage (%)")
ax.legend(loc='upper left')
plt.xticks(rotation=45)
plt.tight_layout()
plt.ylim([0, 100])
plt.grid()


plt.show()
