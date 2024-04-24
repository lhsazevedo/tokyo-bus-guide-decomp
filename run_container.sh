SDK_PATH = ../tokyobus_sdk

docker run -itv .:/app -v $SDK_PATH:/sdk -w /app -u 1000 lhsazevedo/tbg-decomp bash