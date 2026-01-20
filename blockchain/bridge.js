const path = require('path');
// PERBAIKAN: Gunakan path absolut agar file .env selalu ketemu
// meskipun dipanggil dari folder luar (Laravel)
require('dotenv').config({ path: path.resolve(__dirname, '.env') });

const { Web3 } = require('web3');
const fs = require('fs');

// 1. Koneksi ke Ganache
const web3 = new Web3(process.env.RPC_URL);

// 2. Siapkan Data Kontrak
const contractAddress = process.env.CONTRACT_ADDRESS;
const privateKey = process.env.PRIVATE_KEY;
const account = web3.eth.accounts.privateKeyToAccount(privateKey);
web3.eth.accounts.wallet.add(account);

const artifactPath = path.resolve(__dirname, 'build/contracts/DataIntegrity.json');
const contractArtifact = JSON.parse(fs.readFileSync(artifactPath, 'utf8'));
const contract = new web3.eth.Contract(contractArtifact.abi, contractAddress);

async function main() {
    const action = process.argv[2]; 
    const trxId = process.argv[3];  
    const dataHash = process.argv[4]; 

    try {
        if (action === 'store') {
            console.log(`Sedang mengirim hash ke Blockchain... ID: ${trxId}`);
            const gasEstimate = await contract.methods.storeHash(trxId, dataHash).estimateGas({ from: account.address });
            const gasLimit = Math.floor(Number(gasEstimate) * 1.2); 
            const receipt = await contract.methods.storeHash(trxId, dataHash).send({
                from: account.address,
                gas: gasLimit.toString()
            });
            console.log("SUKSES");
            console.log("TX_HASH:" + receipt.transactionHash); 
        
        } else if (action === 'verify') {
            const isValid = await contract.methods.verifyHash(trxId, dataHash).call();
            console.log(isValid ? "VALID" : "INVALID");
        
        } 
        // --- FITUR BARU: MENGHITUNG TOTAL DATA ---
        else if (action === 'count') {
            // Kita hitung berdasarkan Event 'LogHashStored' yang pernah terjadi
            const events = await contract.getPastEvents('LogHashStored', {
                fromBlock: 0,
                toBlock: 'latest'
            });
            console.log("TOTAL_BLOCKCHAIN:" + events.length);
        }
        // -----------------------------------------
        else {
            console.error("Perintah tidak dikenal.");
        }
    } catch (error) {
        console.error("ERROR BLOCKCHAIN:", error.message);
    }
}

main();