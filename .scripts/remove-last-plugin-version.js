const fs = require('fs-extra');
const path = require('path');
const del = require('del');

const pathInfoXml = path.resolve('info.xml');

fs.readFile(pathInfoXml, (err, xmlText) => {
  if (err) {
    console.error(err);
    return;
  }

  const nDate = new Date();

  const regex = /(\<[Vv]ersion[\ a-zA-Z\=\"\'0-9]*\>[\s]*[\<\>\/\-A-Za-z0-9\_]*[\s]*\<\/[Vv]ersion\>)/g;
  const versionArr = xmlText.toString().split(regex);
  versionArr.pop();
  versionArr.shift();
  const lastVersionXmlStr = versionArr[versionArr.length - 1];

  const regexNr = /nr\=\"([0-9]*)\"/g;

  let m;

  while ((m = regexNr.exec(lastVersionXmlStr)) !== null) {
    // This is necessary to avoid infinite loops with zero-width matches
    if (m.index === regexNr.lastIndex) {
      regexNr.lastIndex++;
    }

    const lastVersionNr = parseInt(m[1], 10);

    const newXmlText = xmlText.toString().replace(lastVersionXmlStr, '');

    fs.writeFile(pathInfoXml, newXmlText, (err) => {
      if (err) {
        console.error(err);
        return;
      }
    });

    del(path.resolve('version', lastVersionNr));
  }
});
