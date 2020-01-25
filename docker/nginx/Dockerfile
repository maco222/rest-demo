FROM webdevops/php-nginx-dev:alpine-php7

RUN rm -rf /var/lib/nginx/logs && \
    echo https://dl-4.alpinelinux.org/alpine/v3.9/main > /etc/apk/repositories && \
    echo http://dl-cdn.alpinelinux.org/alpine/v3.9/community >> /etc/apk/repositories && \
    /usr/local/bin/apk-upgrade
RUN rm /etc/nginx/conf.d/default.conf

RUN cat /etc/alpine-release

ENV TZ=Europe/Warsaw

COPY docker/nginx/conf/ /opt/docker/
COPY docker/nginx/conf/.inputrc /root/

RUN set -x &\
    apk-install \
    acl \
    bash-completion \
    vim \
    make \
    tzdata \
    php7-pecl-mongodb

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc
RUN echo 'if [ -f /etc/bash_completion ]; then . /etc/bash_completion; fi' >> ~/.bashrc

ENV term=rxvt
ENV TERM=rxvt

RUN cp /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /app
