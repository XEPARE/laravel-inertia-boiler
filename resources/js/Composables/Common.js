import {usePage} from '@inertiajs/vue3'
import {trans} from 'laravel-vue-i18n'

const page = usePage()

export const __ = (key, replace = {}) => trans(key, replace)

export const can = (permission, strict = false) => {
    if (!strict && page.props.auth.can.indexOf('*') !== -1)
        return true

    permission = permission.toLowerCase()

    /* Wildcard Permissions Check [like can('USER_*') => checking if one item startWith USER] */
    if (permission.endsWith('*')) {
        for (const item of page.props.auth.can) {
            if (item.toLowerCase().startsWith(permission.split('_')[0])) {
                return true
            }
        }
    }

    return page.props.auth.can.indexOf(permission) !== -1
}

export const debounce = (func, wait) => {
    let timeout
    return function (...args) {
        clearTimeout(timeout)
        timeout = setTimeout(() => func.apply(this, args), wait)
    }
}

export const asset = (path) => {
    let base_path = window._asset || location.origin;
    if (!path.startsWith('/'))
        path = "/" + path;
    return base_path + path;
}
