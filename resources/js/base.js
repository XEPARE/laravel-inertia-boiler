module.exports = {
    methods: {

        /**
         * Translate the given key.
         */
        __(key, replace = {}) {
            return this.$t(key, replace);
        },

        can(permission) {
            return this.$page.props.auth.can.indexOf(permission) !== -1;
        },

        dateTime(value) {
            return moment(value).format('DD.MM.YYYY - HH:mm');
        },

        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },

        bytesToHuman(bytes) {
            if (bytes === 0) {
                return '0 kB';
            }

            const i = Math.floor(Math.log(bytes) / Math.log(1024));
            return `${Number((bytes / Math.pow(1024, i)).toFixed(2))} ${['Bytes', 'kB', 'MB', 'GB', 'TB'][i]}`;
        },

        megabytesToHuman(mb) {
            return this.bytesToHuman(this.megabytesToBytes(mb));
        },

        bytesToMegabytes(bytes) {
            return Math.floor(bytes / 1024 / 1024)
        },

        megabytesToBytes(mb) {
            return Math.floor(mb * 1024 * 1024);
        },

        cleanDirectoryPath(path) {
            path.replace(/(\/(\/*))|(^$)/g, '/')
        },

        fileBitsToString(mode, directory) {
            const m = parseInt(mode, 8);

            let buf = '';
            'dalTLDpSugct?'.split('').forEach((c, i) => {
                if ((m & (1 << (32 - 1 - i))) !== 0) {
                    buf = buf + c;
                }
            });

            if (buf.length === 0) {
                // If the file is directory, make sure it has the directory flag.
                if (directory) {
                    buf = 'd';
                } else {
                    buf = '-';
                }
            }

            'rwxrwxrwx'.split('').forEach((c, i) => {
                if ((m & (1 << (9 - 1 - i))) !== 0) {
                    buf = buf + c;
                } else {
                    buf = buf + '-';
                }
            });

            return buf;
        },

        encodePathSegments(path) {
            return path.split('/').map(s => encodeURIComponent(s)).join('/');
        },

        hashToPath(hash) {
            return hash.length > 0 ? decodeURIComponent(hash.substr(1)) : '/';
        },

        isFileArchiveType(file) {
            return file.is_file && [
                'application/vnd.rar', // .rar
                'application/x-rar-compressed', // .rar (2)
                'application/x-tar', // .tar
                'application/x-br', // .tar.br
                'application/x-bzip2', // .tar.bz2, .bz2
                'application/gzip', // .tar.gz, .gz
                'application/x-gzip',
                'application/x-lzip', // .tar.lz4, .lz4 (not sure if this mime type is correct)
                'application/x-sz', // .tar.sz, .sz (not sure if this mime type is correct)
                'application/x-xz', // .tar.xz, .xz
                'application/zstd', // .tar.zst, .zst
                'application/zip', // .zip
            ].indexOf(file.mimetype) >= 0;
        },

        isFileEditable(file) {
            if (this.isFileArchiveType(file) || !file.is_file) return false;

            const matches = [
                'application/jar',
                'application/octet-stream',
                'inode/directory',
                /^image\//,
            ];

            return matches.every(m => !file.mimetype.match(m));
        },

        isDirectory(file) {
            return file.mimetype === 'inode/directory';
        },

        encodePathSegments(path) {
            return path.split('/').map(s => encodeURIComponent(s)).join('/');
        },

        hashToPath (hash) {
            return hash.length > 0 ? decodeURIComponent(hash.substr(1)) : '/';
        },

        nl2br(text, reg = /\n\r/g) {
            if (text && text !== null) {
                let i, s = '', lines = text.split(reg), l = lines.length;

                for (i = 0; i < l; ++i) {
                    s += lines[i];
                    (i !== l - 1) && (s += '<br/>');
                }

                return s;
            }
            return text;
        },

        copyToClipboard(value) {
            this.$page.props.jetstream.flash.banner = this.__('The desired value has been saved in the clipboard');
            window.navigator.clipboard.writeText(value);
            setTimeout(() => {
                this.$page.props.jetstream.flash = {};
            }, 3*1000)
        },

        singularize(word) {
            const endings = {
                s: '',
                ies: 'y'
            };
            return word.replace(
                new RegExp(`(${Object.keys(endings).join('|')})$`),
                r => endings[r]
            );
        },

        asset(path) {
            var base_path = window._asset || location.origin;
            if (!path.startsWith('/')) path = "/" + path;
            return base_path + path;
        }

    },
}
