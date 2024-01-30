# FROM bitnami/dotnet-sdk:3.1 as gdibuilder

# RUN apt-get update && apt-get install -y \
#     clang \
#     && rm -rf /var/lib/apt/lists/*

# RUN wget https://github.com/Sappharad/GDIbuilder/archive/refs/heads/master.tar.gz \
#     && tar -xzf master.tar.gz \
#     && cd GDIbuilder-master/buildgdi \
#     && dotnet publish -r linux-x64 --self-contained
    # && ls -lah /app/GDIbuilder-master/buildgdi/bin \
    # && ls -lah /app/GDIbuilder-master/buildgdi/bin/Debug/netcoreapp3.1

# RUN apt-get update && apt-get install -y

FROM php:8.3-cli

RUN dpkg --add-architecture i386 \
    && apt-get update && apt-get install -y \
        wine \
        wine32 \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions and Composer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync \
    && install-php-extensions \
    xdebug \
    zip \
    @composer \
    && rm /usr/local/bin/install-php-extensions

RUN addgroup --gid 1000 user \
    && useradd --create-home --home-dir /home/user --shell /bin/bash --uid 1000 --gid user user

# COPY --from=gdibuilder /app/GDIbuilder-master/buildgdi/bin/Debug/netcoreapp3.1/buildgdi* /bin/
