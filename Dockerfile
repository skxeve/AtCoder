FROM php:7.0-alpine

### install python3.7.3
### https://github.com/docker-library/python/blob/34c9df35e9a69e9f0edde88e861b543edb8bc07a/3.7/alpine3.9/Dockerfile

# ensure local python is preferred over distribution python
ENV PATH /usr/local/bin:$PATH

# http://bugs.python.org/issue19846
# > At the moment, setting "LANG=C" on a Linux system *fundamentally breaks Python 3*, and that's not OK.
ENV LANG C.UTF-8

# install ca-certificates so that HTTPS works consistently
# other runtime dependencies for Python are installed later
RUN apk add --no-cache ca-certificates

ENV GPG_KEY 0D96DF4D4110E5C43FBFB17F2D347EA6AA65421D
ENV PYTHON_VERSION 3.7.3

RUN set -ex \
	&& apk add --no-cache --virtual .fetch-deps \
		gnupg \
		tar \
		xz \
	\
	&& wget -O python.tar.xz "https://www.python.org/ftp/python/${PYTHON_VERSION%%[a-z]*}/Python-$PYTHON_VERSION.tar.xz" \
	&& wget -O python.tar.xz.asc "https://www.python.org/ftp/python/${PYTHON_VERSION%%[a-z]*}/Python-$PYTHON_VERSION.tar.xz.asc" \
	&& export GNUPGHOME="$(mktemp -d)" \
	&& gpg --batch --keyserver ha.pool.sks-keyservers.net --recv-keys "$GPG_KEY" \
	&& gpg --batch --verify python.tar.xz.asc python.tar.xz \
	&& { command -v gpgconf > /dev/null && gpgconf --kill all || :; } \
	&& rm -rf "$GNUPGHOME" python.tar.xz.asc \
	&& mkdir -p /usr/src/python \
	&& tar -xJC /usr/src/python --strip-components=1 -f python.tar.xz \
	&& rm python.tar.xz \
	\
	&& apk add --no-cache --virtual .build-deps  \
		bzip2-dev \
		coreutils \
		dpkg-dev dpkg \
		expat-dev \
		findutils \
		gcc \
		gdbm-dev \
		libc-dev \
		libffi-dev \
		libnsl-dev \
		libtirpc-dev \
		linux-headers \
		make \
		ncurses-dev \
		openssl-dev \
		pax-utils \
		readline-dev \
		sqlite-dev \
		tcl-dev \
		tk \
		tk-dev \
		util-linux-dev \
		xz-dev \
		zlib-dev \
# add build deps before removing fetch deps in case there's overlap
	&& apk del .fetch-deps \
	\
	&& cd /usr/src/python \
	&& gnuArch="$(dpkg-architecture --query DEB_BUILD_GNU_TYPE)" \
	&& ./configure \
		--build="$gnuArch" \
		--enable-loadable-sqlite-extensions \
		--enable-shared \
		--with-system-expat \
		--with-system-ffi \
		--without-ensurepip \
	&& make -j "$(nproc)" \
# set thread stack size to 1MB so we don't segfault before we hit sys.getrecursionlimit()
# https://github.com/alpinelinux/aports/commit/2026e1259422d4e0cf92391ca2d3844356c649d0
		EXTRA_CFLAGS="-DTHREAD_STACK_SIZE=0x100000" \
	&& make install \
	\
	&& find /usr/local -type f -executable -not \( -name '*tkinter*' \) -exec scanelf --needed --nobanner --format '%n#p' '{}' ';' \
		| tr ',' '\n' \
		| sort -u \
		| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
		| xargs -rt apk add --no-cache --virtual .python-rundeps \
	&& apk del .build-deps \
	\
	&& find /usr/local -depth \
		\( \
			\( -type d -a \( -name test -o -name tests \) \) \
			-o \
			\( -type f -a \( -name '*.pyc' -o -name '*.pyo' \) \) \
		\) -exec rm -rf '{}' + \
	&& rm -rf /usr/src/python \
	\
	&& python3 --version

# make some useful symlinks that are expected to exist
RUN cd /usr/local/bin \
	&& ln -s idle3 idle \
	&& ln -s pydoc3 pydoc \
	&& ln -s python3 python \
	&& ln -s python3-config python-config

# if this is called "PIP_VERSION", pip explodes with "ValueError: invalid truth value '<VERSION>'"
ENV PYTHON_PIP_VERSION 19.1.1

RUN set -ex; \
	\
	wget -O get-pip.py 'https://bootstrap.pypa.io/get-pip.py'; \
	\
	python get-pip.py \
		--disable-pip-version-check \
		--no-cache-dir \
		"pip==$PYTHON_PIP_VERSION" \
	; \
	pip --version; \
	\
	find /usr/local -depth \
		\( \
			\( -type d -a \( -name test -o -name tests \) \) \
			-o \
			\( -type f -a \( -name '*.pyc' -o -name '*.pyo' \) \) \
		\) -exec rm -rf '{}' +; \
	rm -f get-pip.py

### end install python3.7.3

RUN apk add bash bash-completion
RUN apk add curl tree vim git
RUN apk add perl openssh

RUN curl https://raw.githubusercontent.com/skxeve/dotfiles/master/install.sh | bash
RUN curl -fLo ~/.vim/autoload/plug.vim --create-dirs https://raw.githubusercontent.com/junegunn/vim-plug/master/plug.vim
RUN git clone https://github.com/fatih/vim-go.git ~/.vim/plugged/vim-go

RUN git clone https://github.com/skxeve/atcoder-tools.git /root/git/github.com/skxeve/atcoder-tools
RUN cd /root/git/github.com/skxeve/atcoder-tools/ && git checkout feature/add-php7

RUN echo "#!/usr/local/bin/python" > /root/git/github.com/skxeve/atcoder-tools/debug.py
RUN echo "# -*- coding: utf-8 -*-" >> /root/git/github.com/skxeve/atcoder-tools/debug.py
RUN echo "import re" >> /root/git/github.com/skxeve/atcoder-tools/debug.py
RUN echo "import sys" >> /root/git/github.com/skxeve/atcoder-tools/debug.py
RUN echo "" >> /root/git/github.com/skxeve/atcoder-tools/debug.py
RUN echo "from atcodertools.atcoder_tools import main" >> /root/git/github.com/skxeve/atcoder-tools/debug.py
RUN echo "" >> /root/git/github.com/skxeve/atcoder-tools/debug.py
RUN echo "if __name__ == '__main__':" >> /root/git/github.com/skxeve/atcoder-tools/debug.py
RUN echo "    sys.argv[0] = re.sub(r'(-script\.pyw?|\.exe)?$', '', sys.argv[0])" >> /root/git/github.com/skxeve/atcoder-tools/debug.py
RUN echo "    sys.exit(main())" >> /root/git/github.com/skxeve/atcoder-tools/debug.py

RUN chmod 0755 /root/git/github.com/skxeve/atcoder-tools/debug.py
RUN ln -s /root/git/github.com/skxeve/atcoder-tools/debug.py /usr/local/bin/atcoder-tools

RUN pip install -U pip
RUN pip install -r /root/git/github.com/skxeve/atcoder-tools/requirements.txt

WORKDIR /root/work
