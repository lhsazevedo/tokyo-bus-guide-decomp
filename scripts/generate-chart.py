import matplotlib.pyplot as plt
from datetime import datetime, timedelta


dates = [datetime(2024, 1, 1), datetime(2024, 7, 19), datetime(2024, 11, 1),]
matched_code = [2.0, 12.6, 14.7,]
decompiled_code = [1.0, 1.3, 1.3,]


fig, ax = plt.subplots()
ax.stackplot(dates, decompiled_code, matched_code,
             labels=['Matched Code', 'Decompiled Code'],
             colors=['#6a9fb5', '#4f81bd'])


ax.set_title("Matched vs. Decompiled Code Over Time")
ax.set_xlabel("Date")
ax.set_ylabel("Percentage (%)")
ax.legend(loc='upper left')
plt.xticks(rotation=45)
plt.tight_layout()
plt.ylim([0, 100])

plt.show()
