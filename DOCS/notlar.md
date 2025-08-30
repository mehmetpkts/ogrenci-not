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

## Öğrenciler Yeni

- id
- ad_soyad (string)
- ogrenci_no
- telefon_numarasi
- okul_email

## Eğitmenler Yeni

- id
- ad_soyad (string)
- egitmen_no
- telefon_numarasi
- okul_email

ogrenci_no, egitmen_no: genelde “kurum içi benzersiz kimlik”tir.
Tür: string (örn. length 50)
Kısıt: unique index
Gereklilik: required (yoksa nullable yapın)
telefon_numarasi: farklı formatlar sebebiyle string tutun.
Tür: string(20–30)
Kısıt: opsiyonel; dilerseniz index ekleyebilirsiniz
Gereklilik: nullable önerilir
okul_email: e-posta
Tür: string(255)
Kısıt: unique index
Gereklilik: varsa required, değilse nullable
