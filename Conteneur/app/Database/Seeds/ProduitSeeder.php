public function run() {
    $data = [
        'nom' => 'Dracaufeu',
        'prix' => 150.00,
        // ...
    ];
    $this->db->table('produits')->insert($data);
}