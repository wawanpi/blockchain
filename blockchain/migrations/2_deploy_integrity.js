const DataIntegrity = artifacts.require("DataIntegrity");

module.exports = function (deployer) {
  deployer.deploy(DataIntegrity);
};