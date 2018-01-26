const fs = require('fs');
const path = require('path');
const find = require('find');
const sass = require('sass');

/**
 * Find and compile SASS & SCSS files
 */
find.file(/\.(sass|scss)$/, path.resolve('version'), function (files) {
    files.forEach((file) => {
        const result = sass.renderSync({ file: file });
        fs.writeFileSync(
            path.dirname(file) + '/../' + path.basename(file).replace(path.extname(file), `.css`),
            result.css.toString()
        );
    });
});
