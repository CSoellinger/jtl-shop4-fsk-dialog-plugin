const fs = require('fs-extra');
const path = require('path');
const argv = require('yargs').argv;
const semver = require('semver');

const versionStep = argv._[0] || 'patch';

const pathInfoXml = path.resolve('info.xml');
const pathSrc = path.resolve('src');
const pathVersion = path.resolve('version');

const xml = fs.readFileSync(path.resolve('info.xml')).toString();

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
    const lastVersionNrArr = String(lastVersionNr).split('');

    const pathNr = lastVersionNrArr[lastVersionNrArr.length - 1];
    lastVersionNrArr.pop();

    const minorNr = lastVersionNrArr[lastVersionNrArr.length - 1];
    lastVersionNrArr.pop();

    const majorNr = lastVersionNrArr.join('');

    const semVerNr = `${majorNr}.${minorNr}.${pathNr}`;
    const nextSemVerNr = semver.inc(semVerNr, versionStep);

    const actualDate = `${nDate.getFullYear()}-${nDate.getMonth() <= 9 ? '0' + (nDate.getMonth() + 1) : (nDate.getMonth() + 1)}-${nDate.getDate()}`;

    const nextVerXmlStr = xmlText.toString().split(/([\ ]*)\<Version/)[1] + lastVersionXmlStr
      .replace(/(nr\=\")([0-9]*)(\")/, `$1${nextSemVerNr.replace(/\./g, '')}$3`)
      .replace(/(\<[Cc]reate[Dd]ate\>)([0-9\-\.\/]*)(\<\/[Cc]reate[Dd]ate\>)/, `$1${actualDate}$3`);

    const newXmlText = xmlText.toString().replace(lastVersionXmlStr, lastVersionXmlStr + "\n" + nextVerXmlStr);

    fs.writeFile(pathInfoXml, newXmlText, (err) => {
      if (err) {
        console.error(err);
        return;
      }
    });

    fs.copy(pathSrc, path.resolve('version', nextSemVerNr.replace(/\./g, '')));
  }
});
