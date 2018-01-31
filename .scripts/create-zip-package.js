const fs = require('fs-extra');
const path = require('path');
const zip = require('file-zip');
const xml2js = require('xml2js');
const del = require('del');
const copy = require('copy');

const xmlParser = new xml2js.Parser();

const abp = `.${path.sep}`;
const absPathDotFiles = `${abp}.files`;
const absPathVersion = `${abp}version`;
const absPathChangelog = `${abp}CHANGELOG.md`;
const absPathInfoXml = `${abp}info.xml`;
const absPathLicense = `${abp}LICENSE`;
const absPathPreview = `${abp}preview.png`;
const absPathReadme = `${abp}README.md`;
const absPathSettings = `${abp}SETTINGS.md`;

const filesArr = [
  absPathDotFiles, absPathVersion, absPathChangelog, absPathInfoXml, absPathLicense, absPathPreview, absPathReadme, absPathSettings
];

xmlParser.parseString(fs.readFileSync(absPathInfoXml), async (err, xmlData) => {
  const pkgName = xmlData.jtlshop3plugin.PluginID[0];
  const absPathZipDir = `${abp}${pkgName}`;
  const pathZipDir = path.resolve(absPathZipDir);

  if (fs.existsSync(pathZipDir)) {
    await del([pathZipDir]);
  }

  fs.mkdirpSync(pathZipDir);

  const promiseCopyArr = [];

  filesArr.forEach((file) => {
    const pathFile = path.resolve(file);
    if (fs.pathExistsSync(pathFile)) {
      if (fs.lstatSync(pathFile).isDirectory()) {
        promiseCopyArr.push(fs.copy(file, `${absPathZipDir}${path.sep}${path.basename(file)}`));
      }
      if (fs.lstatSync(file).isFile()) {
        promiseCopyArr.push(copy(file, `${absPathZipDir}${path.sep}.`, (err) => { if (err) { console.error(err); } }));
      }
    }
  });

  Promise.all(promiseCopyArr).then(async (res) => {
    const versionArr = xmlData.jtlshop3plugin.Install[0].Version;
    const lastVersion = versionArr[versionArr.length - 1];
    const lastVersionNr = parseInt(lastVersion.$.nr, 10);
    const lastVersionNrArr = String(lastVersionNr).split('');

    const pathNr = lastVersionNrArr[lastVersionNrArr.length - 1];
    lastVersionNrArr.pop();

    const minorNr = lastVersionNrArr[lastVersionNrArr.length - 1];
    lastVersionNrArr.pop();

    const majorNr = lastVersionNrArr.join('');

    const semVerNr = `${majorNr}.${minorNr}.${pathNr}`;

    const zipFile = `${abp}${pkgName}_${semVerNr}.zip`;

    if (fs.existsSync(path.resolve(zipFile))) {
      await del([path.resolve(zipFile)]);
    }

    zip.zipFolder(absPathZipDir, zipFile, function (err) {
      if (err) {
        console.error(err)
        return;
      }
      del([pathZipDir]);
    });
  }).catch((err) => { console.error(err); });
});
