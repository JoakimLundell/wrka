
export default {
    capitalize: capitalize,
    onlyUnique: onlyUnique
}

function capitalize(s) {
    if (typeof s !== 'string')
        return '';
    s = s.toLowerCase();
    return s.charAt(0).toUpperCase() + s.slice(1);
}

function onlyUnique(value, index, self) { 
    return self.indexOf(value) === index;
}
