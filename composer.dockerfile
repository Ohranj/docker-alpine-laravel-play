FROM composer:2

ENV COMPOSERUSER=fitness
ENV COMPOSERGROUP=fitness

RUN adduser -g ${COMPOSERGROUP} -s /bin/sh -D ${COMPOSERUSER}