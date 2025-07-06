<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SSL Certificate Generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8" x-data="sslCertificateApp()">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                <i class="fas fa-shield-alt text-green-600 mr-3"></i>
                SSL Certificate Generator
            </h1>
            <p class="text-gray-600">Generate self-signed SSL certificates for development and testing</p>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Certificate Generator Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                    <i class="fas fa-plus-circle text-blue-600 mr-2"></i>
                    Generate New Certificate
                </h2>

                <form @submit.prevent="generateCertificate" class="space-y-4">
                    <!-- Common Name -->
                    <div>
                        <label for="common_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Common Name (CN) *
                        </label>
                        <input type="text" id="common_name" x-model="form.common_name" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., localhost, example.com">
                        <p class="text-xs text-gray-500 mt-1">The domain name for the certificate</p>
                    </div>

                    <!-- Organization -->
                    <div>
                        <label for="organization" class="block text-sm font-medium text-gray-700 mb-1">
                            Organization (O) *
                        </label>
                        <input type="text" id="organization" x-model="form.organization" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., My Company Inc.">
                    </div>

                    <!-- Organizational Unit -->
                    <div>
                        <label for="organizational_unit" class="block text-sm font-medium text-gray-700 mb-1">
                            Organizational Unit (OU)
                        </label>
                        <input type="text" id="organizational_unit" x-model="form.organizational_unit"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., IT Department">
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">
                            Country (C) *
                        </label>
                        <input type="text" id="country" x-model="form.country" required maxlength="2"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., US">
                        <p class="text-xs text-gray-500 mt-1">2-letter ISO country code</p>
                    </div>

                    <!-- State -->
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">
                            State/Province (ST) *
                        </label>
                        <input type="text" id="state" x-model="form.state" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., California">
                    </div>

                    <!-- Locality -->
                    <div>
                        <label for="locality" class="block text-sm font-medium text-gray-700 mb-1">
                            City/Locality (L) *
                        </label>
                        <input type="text" id="locality" x-model="form.locality" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., San Francisco">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email Address *
                        </label>
                        <input type="email" id="email" x-model="form.email" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., admin@example.com">
                    </div>

                    <!-- Validity Period -->
                    <div>
                        <label for="valid_days" class="block text-sm font-medium text-gray-700 mb-1">
                            Validity Period (Days) *
                        </label>
                        <input type="number" id="valid_days" x-model="form.valid_days" required min="1" max="3650"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="365">
                        <p class="text-xs text-gray-500 mt-1">1-3650 days (max 10 years)</p>
                    </div>

                    <!-- Key Size -->
                    <div>
                        <label for="key_size" class="block text-sm font-medium text-gray-700 mb-1">
                            Key Size *
                        </label>
                        <select id="key_size" x-model="form.key_size" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="2048">2048 bits (Recommended)</option>
                            <option value="4096">4096 bits (High Security)</option>
                            <option value="1024">1024 bits (Legacy)</option>
                        </select>
                    </div>

                    <!-- Private Key Password -->
                    <div>
                        <label for="private_key_password" class="block text-sm font-medium text-gray-700 mb-1">
                            Private Key Password (Optional)
                        </label>
                        <input type="password" id="private_key_password" x-model="form.private_key_password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Leave empty for no password protection">
                        <p class="text-xs text-gray-500 mt-1">Password to encrypt the private key file</p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" :disabled="loading"
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-spinner fa-spin mr-2" x-show="loading"></i>
                        <span x-text="loading ? 'Generating Certificate...' : 'Generate Certificate'"></span>
                    </button>
                </form>

                <!-- Error Messages -->
                <div x-show="errors.length > 0" class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
                    <ul class="text-red-700 text-sm space-y-1">
                        <template x-for="error in errors" :key="error">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>
            </div>

            <!-- Certificate List -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        <i class="fas fa-certificate text-green-600 mr-2"></i>
                        Generated Certificates
                    </h2>
                    <button @click="loadCertificates" :disabled="loadingCertificates"
                            class="text-blue-600 hover:text-blue-800 disabled:opacity-50">
                        <i class="fas fa-sync-alt" :class="{ 'fa-spin': loadingCertificates }"></i>
                    </button>
                </div>

                <div x-show="certificates.length === 0" class="text-center py-8 text-gray-500">
                    <i class="fas fa-certificate text-4xl mb-4"></i>
                    <p>No certificates generated yet</p>
                </div>

                <div x-show="certificates.length > 0" class="space-y-4">
                    <template x-for="cert in certificates" :key="cert.directory">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-semibold text-gray-800" x-text="cert.info.subject.CN || 'Unknown'"></h3>
                                    <p class="text-sm text-gray-600" x-text="cert.info.subject.O || 'Unknown Organization'"></p>
                                </div>
                                <div class="flex space-x-2">
                                    <button @click="viewCertificate(cert)" 
                                            class="text-blue-600 hover:text-blue-800 text-sm">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </button>
                                    <button @click="deleteCertificate(cert.directory)" 
                                            class="text-red-600 hover:text-red-800 text-sm">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Valid From:</span>
                                    <span x-text="formatDate(cert.info.valid_from)"></span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Valid To:</span>
                                    <span x-text="formatDate(cert.info.valid_to)"></span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Days Remaining:</span>
                                    <span :class="cert.info.days_remaining < 30 ? 'text-red-600' : 'text-green-600'"
                                          x-text="cert.info.days_remaining"></span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Status:</span>
                                    <span :class="cert.info.is_expired ? 'text-red-600' : 'text-green-600'"
                                          x-text="cert.info.is_expired ? 'Expired' : 'Valid'"></span>
                                </div>
                            </div>

                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <div class="flex space-x-2">
                                    <button @click="downloadFile(cert.certificate_path, 'certificate')"
                                            class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded hover:bg-green-200">
                                        <i class="fas fa-download mr-1"></i>Certificate
                                    </button>
                                    <button @click="downloadFile(cert.directory + '/private.key', 'private_key')"
                                            class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded hover:bg-red-200">
                                        <i class="fas fa-key mr-1"></i>Private Key
                                    </button>
                                    <button @click="downloadFile(cert.directory + '/combined.pem', 'combined')"
                                            class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded hover:bg-blue-200">
                                        <i class="fas fa-file-code mr-1"></i>Combined
                                    </button>
                                    <button @click="downloadFile(cert.directory + '/certificate.pfx', 'pfx')"
                                            class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded hover:bg-purple-200">
                                        <i class="fas fa-file-archive mr-1"></i>PFX
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Certificate Modal -->
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
             @click.self="showModal = false">
            <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b">
                    <h3 class="text-lg font-semibold" x-text="selectedCertificate?.info?.subject?.CN || 'Certificate Details'"></h3>
                    <button @click="showModal = false" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold mb-3">Certificate Information</h4>
                            <div class="space-y-2 text-sm">
                                <div><span class="font-medium">Common Name:</span> <span x-text="selectedCertificate?.info?.subject?.CN"></span></div>
                                <div><span class="font-medium">Organization:</span> <span x-text="selectedCertificate?.info?.subject?.O"></span></div>
                                <div><span class="font-medium">Country:</span> <span x-text="selectedCertificate?.info?.subject?.C"></span></div>
                                <div><span class="font-medium">State:</span> <span x-text="selectedCertificate?.info?.subject?.ST"></span></div>
                                <div><span class="font-medium">City:</span> <span x-text="selectedCertificate?.info?.subject?.L"></span></div>
                                <div><span class="font-medium">Email:</span> <span x-text="selectedCertificate?.info?.subject?.emailAddress"></span></div>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-3">Validity</h4>
                            <div class="space-y-2 text-sm">
                                <div><span class="font-medium">Valid From:</span> <span x-text="formatDate(selectedCertificate?.info?.valid_from)"></span></div>
                                <div><span class="font-medium">Valid To:</span> <span x-text="formatDate(selectedCertificate?.info?.valid_to)"></span></div>
                                <div><span class="font-medium">Days Remaining:</span> <span x-text="selectedCertificate?.info?.days_remaining"></span></div>
                                <div><span class="font-medium">Serial Number:</span> <span x-text="selectedCertificate?.info?.serial_number"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <h4 class="font-semibold mb-3">Certificate Content</h4>
                        <pre class="bg-gray-100 p-4 rounded text-xs overflow-x-auto" x-text="selectedCertificate?.certificateContent || 'Loading...'"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function sslCertificateApp() {
            return {
                form: {
                    common_name: 'localhost',
                    organization: 'My Organization',
                    organizational_unit: 'IT Department',
                    country: 'US',
                    state: 'State',
                    locality: 'City',
                    email: 'admin@example.com',
                    valid_days: 365,
                    key_size: 2048,
                    private_key_password: ''
                },
                certificates: [],
                loading: false,
                loadingCertificates: false,
                errors: [],
                showModal: false,
                selectedCertificate: null,

                async generateCertificate() {
                    this.loading = true;
                    this.errors = [];

                    try {
                        const response = await fetch('{{ route("ssl-certificates.generate") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                            },
                            body: JSON.stringify(this.form)
                        });

                        const result = await response.json();

                        if (result.success) {
                            // Reset form
                            this.form = {
                                common_name: 'localhost',
                                organization: 'My Organization',
                                organizational_unit: 'IT Department',
                                country: 'US',
                                state: 'State',
                                locality: 'City',
                                email: 'admin@example.com',
                                valid_days: 365,
                                key_size: 2048,
                                private_key_password: ''
                            };
                            
                            // Reload certificates
                            await this.loadCertificates();
                            
                            // Show success message
                            alert('Certificate generated successfully!');
                        } else {
                            this.errors = result.errors || [result.message];
                        }
                    } catch (error) {
                        this.errors = ['An error occurred while generating the certificate'];
                        console.error('Error:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                async loadCertificates() {
                    this.loadingCertificates = true;
                    try {
                        const response = await fetch('{{ route("ssl-certificates.list") }}');
                        const result = await response.json();
                        
                        if (result.success) {
                            this.certificates = result.data;
                        }
                    } catch (error) {
                        console.error('Error loading certificates:', error);
                    } finally {
                        this.loadingCertificates = false;
                    }
                },

                async viewCertificate(cert) {
                    this.selectedCertificate = cert;
                    this.showModal = true;
                    
                    try {
                        const response = await fetch(`{{ route("ssl-certificates.content") }}?file_path=${encodeURIComponent(cert.certificate_path)}`);
                        const result = await response.json();
                        
                        if (result.success) {
                            this.selectedCertificate.certificateContent = result.data.content;
                        }
                    } catch (error) {
                        console.error('Error loading certificate content:', error);
                    }
                },

                async deleteCertificate(directory) {
                    if (!confirm('Are you sure you want to delete this certificate?')) {
                        return;
                    }

                    try {
                        const response = await fetch('{{ route("ssl-certificates.delete") }}', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                            },
                            body: JSON.stringify({ directory })
                        });

                        const result = await response.json();
                        
                        if (result.success) {
                            await this.loadCertificates();
                        } else {
                            alert('Failed to delete certificate');
                        }
                    } catch (error) {
                        console.error('Error deleting certificate:', error);
                        alert('An error occurred while deleting the certificate');
                    }
                },

                downloadFile(filePath, fileType) {
                    const url = `{{ route("ssl-certificates.download") }}?file_path=${encodeURIComponent(filePath)}&file_type=${fileType}`;
                    window.open(url, '_blank');
                },

                formatDate(dateString) {
                    if (!dateString) return 'N/A';
                    return new Date(dateString).toLocaleDateString();
                },

                init() {
                    this.loadCertificates();
                }
            }
        }
    </script>
</body>
</html> 