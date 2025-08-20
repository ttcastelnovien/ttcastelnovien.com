FROM gotenberg/gotenberg:8

USER root

RUN apt-get update -qq &&\
    DEBIAN_FRONTEND=noninteractive apt-get install -y -qq --no-install-recommends -t bookworm-backports libreoffice-l10n-de &&\
    sed -i '/fr_FR.UTF-8/s/^# //g' /etc/locale.gen &&\
    locale-gen &&\
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

ENV LANG="fr_FR.UTF-8"
ENV LANGUAGE="fr_FR:fr"
ENV LC_ALL="fr_FR.UTF-8"

COPY gotenberg/fonts/* /usr/local/share/fonts/

USER gotenberg

CMD ["gotenberg"]
