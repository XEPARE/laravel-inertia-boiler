export default {
    methods: {

        /**
         * Translate the given key.
         */
        __(key, replace = {}) {
            return this.$t(key, replace);
        },

        can(permission, strict = false) {
            if (!strict && this.$page.props.auth.can.indexOf('*') !== -1)
                return true;

            /* Wildcard Permissions Check [like can('USER_*') => checking if one item startWith USER] */
            if (permission.endsWith('*')) {
                for (let item of this.$page.props.auth.can) {
                    if (item.startsWith(permission.split('_')[0])) {
                        return true;
                    }
                }
            }

            return this.$page.props.auth.can.indexOf(permission) !== -1;
        },


        dateTime(value) {
            return moment(value).format('DD.MM.YYYY - HH:mm');
        },

        capitalizeFirstLetter(string) {
            string = string.toLowerCase();
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
            }, 3 * 1000)
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
        },

        uppercaseWords(str) {
            return str.replace(/(^|\s)\S/g, l => l.toUpperCase());
        },

        debounce(fn, delay) {
            let timeoutId
            return function (...args) {
                clearTimeout(timeoutId)
                timeoutId = setTimeout(() => fn.apply(this, args), delay)
            }
        },

        readableCronExpression(expression) {
            return cronstrue.toString(expression);
        },

        price(number, suffix = '€') {
            number = parseFloat(number);
            number = number.toFixed(2) + '';
            x = number.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2 + ' ' + suffix;
        },

        getTrendByValues(now, previous) {
            if (now === previous) {
                return '0%';
            }
            if (previous == 0) {
                return '';
            }
            let trend;
            let diff = (now - previous) / previous * 100;
            if (diff > 0) {
                trend = `+${parseFloat(diff).toFixed(0)}%`;
            } else if (diff < 0) {
                trend = `${parseFloat(diff).toFixed(0)}%`;
            } else {
                trend = `0%`;
            }
            return trend;
        },

        getTimeDifference(start, end) {
            var diff = Math.abs(new Date(start) - new Date(end));
            var diffInSeconds = diff / 1000;
            var diffInMinutes = diffInSeconds / 60;
            var diffInHours = diffInMinutes / 60;
            var diffInDays = diffInHours / 24;
            var diffInWeeks = diffInDays / 7;

            if (diffInWeeks >= 1) {
                return Math.floor(diffInWeeks) + " weeks";
            } else if (diffInDays >= 1) {
                return Math.floor(diffInDays) + " days";
            } else if (diffInHours >= 1) {
                return Math.floor(diffInHours) + " hours";
            } else if (diffInMinutes >= 1) {
                return Math.floor(diffInMinutes) + " minutes";
            } else {
                return Math.floor(diffInSeconds) + " seconds";
            }
        },

        getDates(startDate, endDate) {
            var dateArray = [];
            var currentDate = moment(startDate);
            var endDate = moment(endDate);
            while (currentDate <= endDate) {
                dateArray.push( moment(currentDate).format('YYYY-MM-DD') )
                currentDate = moment(currentDate).add(1, 'days');
            }
            return dateArray;
        }

    },
}
