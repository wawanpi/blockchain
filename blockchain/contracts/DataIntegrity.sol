// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

contract DataIntegrity {
    address public owner;

    // Mapping: ID Transaksi (String) => Hash Transaksi (String)
    mapping(string => string) private hashes;
    
    // Event: Agar Laravel bisa mendengar kalau data sukses masuk
    event LogHashStored(string indexed transactionId, string storedHash, uint256 timestamp);

    constructor() {
        owner = msg.sender;
    }

    modifier onlyOwner() {
        require(msg.sender == owner, "Hanya Admin Burjo Minang yang boleh input data!");
        _;
    }

    // Fungsi Utama: Simpan Hash
    function storeHash(string memory _trxId, string memory _hash) public onlyOwner {
        // Validasi: Pastikan ID ini belum pernah ada (IMMUTABLE)
        // Jika string hash di mapping kosong, berarti ID belum terpakai
        require(bytes(hashes[_trxId]).length == 0, "Data ID ini sudah terkunci permanen di Blockchain!");
        
        hashes[_trxId] = _hash;
        emit LogHashStored(_trxId, _hash, block.timestamp);
    }

    // Fungsi Cek: Verifikasi Data
    function verifyHash(string memory _trxId, string memory _compareHash) public view returns (bool) {
        return keccak256(abi.encodePacked(hashes[_trxId])) == keccak256(abi.encodePacked(_compareHash));
    }
}