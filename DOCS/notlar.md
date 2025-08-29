# Laravel Oluşturulacak tablolar

## Öğrenciler (ogrenciler)

- id
- ad_soyad (string)

## Eğitmenler (egitmenler)

- id
- ad_soyad (string)

## Dersler (dersler)

- id
- ad (string) — dokümandaki “ders”
- egitmen_id (foreign, egitmenler.id)

## Notlar (notlar)

- id
- ogrenci_id (foreign, ogrenciler.id)
- ders_id (foreign, dersler.id)
- not (integer veya decimal)
