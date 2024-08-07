FROM bitnami/dotnet-sdk:6 as gdibuilder

COPY gdibuilder.patch /app/gdibuilder.patch

RUN apt-get update && apt-get install -y \
    clang \
    zlib1g-dev \
    libkrb5-dev \
    libtinfo5 \
    && rm -rf /var/lib/apt/lists/*

RUN cd /app \
    && git clone https://github.com/Sappharad/GDIbuilder.git \
    && cd GDIbuilder \
    && git apply /app/gdibuilder.patch \
    && cd buildgdi \
    && dotnet publish --configuration Release -r linux-x64 --self-contained


FROM php:8.3-cli

RUN dpkg --add-architecture i386 \
    && apt-get update && apt-get install -y --no-install-recommends \
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

COPY --from=gdibuilder /app/GDIbuilder/buildgdi/bin/Release/net6.0/linux-x64/publish /opt/buildgdi

RUN ln -s /opt/buildgdi/buildgdi /usr/local/bin/buildgdi
