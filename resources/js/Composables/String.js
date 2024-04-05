export const capitalizeFirstLetter = (string) => {
    string = string.toLowerCase();
    return string.charAt(0).toUpperCase() + string.slice(1);
}

export const uppercaseWords = (string) => string.replace(/(^|\s)\S/g, l => l.toUpperCase())

export const truncateText = (content, length, suffix = '...') => {
    if (content.length <= length)
        return content
    return content.substring(0, length) + suffix
}

export const truncateWords = (content, limit, suffix = '...') => {
    const words = content.split(' ')

    if (words.length <= limit)
        return content

    return words.slice(0, limit).join(' ') + suffix
}

export const singular = (string) => {
    const endings = {
        s: '',
        ies: 'y'
    };
    return string.replace(
        new RegExp(`(${Object.keys(endings).join('|')})$`),
        r => endings[r]
    );
}

