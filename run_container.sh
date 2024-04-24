SDK_PATH=ABSOLUTE/SDK/PATH

docker run -itv .:/app -v $SDK_PATH:/sdk -w /app -u 1000 lhsazevedo/tbg-decomp bash