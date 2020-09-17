module.exports = {
    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true,
    },
    purge: [
        'resources/ts/**/*.vue',
        'resources/ts/**/*.blade.php',
    ],
    theme: {
        extend: {},
    },
    variants: {},
    plugins: [],
}
